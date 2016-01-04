<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Article;
use App\Comment;
use App\User;
use App\History;
use Auth;
use Validator;
use Markdown;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['getComments']]);
    }

    /*protected function validator(array $data)
    {
        return Validator::make($data, [
            'body' => 'required',
        ]);
    }*/

    public function store(Request $request)
    {
        $article = Article::find($request->article_id);
        if (empty($article))
            return response()->json(['status' => 404, 'msg' => '文章不存在']);

        if (!$article->comment_status)
            return response()->json(['status' => 403, 'msg' => '文章已禁用评论']);

        $rules = array(
            'body' => 'required',
        );
        $validation = Validator::make($data = $request->all(), $rules);
        if ($validation->fails())
            return response()->json(['status' => 0, 'msg' => '评论内容不能为空']);

        $data['user_id'] = Auth::id();
        $data['body'] = Markdown::parse(parseAt($data['body']));
        $comment = Comment::create($data);
        $html = view('articles._comment', compact('comment'))->render();
        $comment->article->increment('comment_count');
        Auth::user()->histories()->create([
            'type' => 'comment',
            'content' => '评论文章《<a href="/article/'.$article->id.'#comment-'.$comment->id.'" target="_blank">'.$article->title.'</a>》'
        ]);
        return response()->json(['status' => 200, 'msg' => '评论成功', 'html' => $html]);
    }

    public function getComments(Request $request)
    {
        $article = Article::find($request->article_id);
        if (empty($article))
            return response()->json(['status' => 404, 'msg' => '文章不存在']);
        $comments = $article->comments()->latest()->simplePaginate(10);
        $html = view('articles._comments', compact('comments'))->render();
        return response()->json(['status' => 200, 'html' => $html]);
    }
}
