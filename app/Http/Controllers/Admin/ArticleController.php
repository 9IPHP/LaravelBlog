<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Article;
use App\Comment;
use App\Tag;
use App\Repositories\ArticleRepository;

class ArticleController extends BaseController
{
    protected $articles;

    public function __construct(ArticleRepository $articles)
    {
        $this->articles = $articles;
        $this->middleware('acl:article.manage');
    }

    public function index(Request $request)
    {
        $orderby = $request->orderby ? $request->orderby : 'created_at';
        $title = $request->title ? $request->title : '';

        $articles =  Article::with('user')
                        ->whereTitle($title)
                        ->Orderby($orderby, 'DESC')
                        ->simplePaginate(10);
        return view('admin.articles.index', compact('articles', 'orderby', 'title'));
    }

    public function destroy($id)
    {
        $article = Article::find($id, ['id' ,'user_id']);
        if (empty($article)) {
            return response()->json(404);
        }
        // delete tags
        $this->articles->delTags($article);
        // TODO: Notice User of Article Delete

        // delete article
        $article->delete();
        return response()->json(200);
    }

    // 回收站
    public function trash()
    {
        $articles = $this->articles->onlyDeleted();
        return view('admin.articles.trash', compact('articles'));
    }

    public function forceDestroy($id)
    {
        $article = Article::onlyTrashed()->with('comments')->find($id, ['id' ,'user_id']);
        if (empty($article)) {
            return response()->json(404);
        }

        // delete article
        $article->forceDelete();
        return response()->json(200);
    }

    public function forceDestroyAll(Request $request)
    {
        $delAll = $request->all;
        $idArr = $request->id;
        if (empty($delAll) && empty($idArr)) {
            return response()->json(403);
        }

        if ($delAll) {
            Article::onlyTrashed()->with('comments')->forceDelete();
        }else{
            Article::onlyTrashed()->whereIn('id', $idArr)->with('comments')->forceDelete();
        }
        return response()->json(200);
    }

    public function restoreDeleted($id)
    {
        $article = Article::onlyTrashed()->find($id, ['id']);
        if(empty($article)) {
            return response()->json(404);
        }
        $this->articles->restoreTags($article);
        $article->restore();
        return response()->json(200);
    }

    public function comments(Request $request)
    {
        $body = $request->body ? $request->body : '';

        $comments = Comment::with('article')
                    ->with('user')
                    ->whereBody($body)
                    ->latest()
                    ->paginate(10);
        return view('admin.articles.comments', compact('comments', 'body'));
    }

    public function tags(Request $request)
    {
        $orderby = $request->orderby ? $request->orderby : 'created_at';
        $name = $request->name ? $request->name : '';
        $tags = Tag::orderBy($orderby, 'DESC')->whereName($name)->paginate(10);
        // dd($tags);
        return view('admin.articles.tags', compact('tags', 'orderby', 'name'));
    }

    public function deltag(Request $request)
    {
        $id = (array) $request->id;
        if(Tag::whereIn('id', $id)->delete()){
            return response()->json(200);
        }else{
            return response()->json(404);
        }
    }

    public function delcomment(Request $request)
    {
        $id = (array) $request->id;
        $comments = Comment::whereIn('id', $id)->get(['article_id']);

        if($comments){
            $articleIds = $comments->fetch('article_id');
            Comment::whereIn('id', $id)->delete();
            foreach ($articleIds as $article_id) {
                 Article::withTrashed()->whereId($article_id)->decrement('comment_count');
            }
            return response()->json(200);
        }else{
            return response()->json(404);
        }

        return response()->json($articleIds);
    }
}
