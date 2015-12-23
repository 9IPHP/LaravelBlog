<?php

namespace App\Http\Controllers;

use Auth, Gate, DB;
use App\User;
use App\Article;
use App\Tag;
use App\Collect;
use App\Image;
use App\History;
use App\Comment;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\Validator;

use App\Repositories\ArticleRepository;

class ArticleController extends Controller
{
    protected $articles, $currentUser;

    public function __construct(ArticleRepository $articles)
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'forUser']]);
        $this->middleware('acl:article.create', ['only' => ['create', 'store', 'edit', 'update', 'active', 'destroy']]);
        $this->middleware('role:editor', ['only' => ['view']]);
        $this->articles = $articles;
        $this->currentUser = Auth::user();
        view()->share('currentUser', $this->currentUser);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $articles = $this->articles->all();
        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::orderBy('count', 'desc')->lists('name', 'slug')->toArray();

        return view('articles.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $requests = $request->all();
        $requests['excerpt'] = $requests['excerpt'] ? $requests['excerpt'] : make_excerpt($requests['body']);

        $article = Auth::user()->articles()->create($requests);
        $this->articles->syncTags($article, $request->tag_list);
        Auth::user()->histories()->create([
            'type' => 'article',
            'content' => '发布文章《<a href="/article/'.$article->id.'" target="_blank">'.$article->title.'</a>》'
        ]);
        flash()->message('文章发布成功！');
        return redirect('article/' . $article->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        if ($article->is_active == 0 && (!Auth::user() || (!Auth::user()->owns($article) && !Auth::user()->can('article.manage'))))
            abort(404);
        $comments = $article->comments()->with('user')->recent()->simplePaginate(10);
        $article->increment('view_count');
        return view('articles.show', compact('article', 'comments'));
    }

    public function view($id)
    {
        $article = Article::withTrashed()->with('user')->findOrFail($id);
        $comments = $article->comments()->with('user')->recent()->simplePaginate(10);
        $article->increment('view_count');
        return view('articles.view', compact('article', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $this->authorize('update', $article);
        $tags = Tag::orderBy('count', 'desc')->lists('name', 'slug')->toArray();
        return view('articles.edit', compact('article', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Article $article, ArticleRequest $request)
    {
        $this->authorize('update', $article);

        $requests = $request->all();

        $this->articles->syncTags($article, $request->tag_list);

        $requests['is_active'] = $request->is_active ? $request->is_active : 0;
        $requests['comment_status'] = $request->comment_status ? $request->comment_status : 0;
        $requests['excerpt'] = $requests['excerpt'] ? $requests['excerpt'] : mb_content_filter_cut($requests['body']);
        $article->update($requests);
        Auth::user()->histories()->create([
            'type' => 'article',
            'content' => '修改文章《<a href="/article/'.$article->id.'" target="_blank">'.$article->title.'</a>》'
        ]);
        flash()->message('文章修改成功！');
        return redirect('article/' . $article->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        if (Gate::denies('destroy', $article))
            return response()->json(403);
        // delete tags
        $this->articles->delTags($article);
        // TODO: delete comments
        // Comment::where('article_id', $article->id)->delete();

        Auth::user()->histories()->create([
            'type' => 'article',
            'content' => '删除文章《<a href="/article/'.$article->id.'" target="_blank">'.$article->title.'</a>》'
        ]);
        // delete article
        $article->delete();
        return response()->json(200);
    }

    public function active(Request $request)
    {
        $article = Article::find($request->id, ['id' ,'user_id']);
        if (empty($article)) return response()->json(404);

        if (Gate::denies('active', $article))
            return response()->json(403);

        $requests = $request->all();
        if (!in_array($request->type, array('is_active', 'comment_status')))
            return response()->json(403);

        $data[$request->type] = $request->newStatus;
        if($article->update($data)) return response()->json(200);
        return response()->json(500);
    }

    public function like(Request $request)
    {
        $article = Article::find($request->id, ['id', 'user_id', 'title']);
        if (empty($article)) return response()->json(['status' => 404]);

        $user_id = Auth::id();

        if($like = $article->likes()->byUser($user_id)->first()){
            $like->delete();
            $article->decrement('like_count');
            return response()->json(['status' => 200, 'action' => 'down']);
        }else{
            $like = $article->likes()->create(['user_id' => $user_id]);
            $article->increment('like_count');
            Auth::user()->histories()->create([
                'type' => 'like',
                'content' => '赞了文章《<a href="/article/'.$article->id.'" target="_blank">'.$article->title.'</a>》'
            ]);
            return response()->json(['status' => 200, 'action' => 'up']);
        }
    }

    public function collect(Request $request)
    {
        $article = Article::find($request->id, ['id', 'user_id', 'title']);

        if (empty($article)) return response()->json(['status' => 404]);

        $user = Auth::user();
        if($collect = Collect::isCollect(Auth::user(), $article)){
            $user->collects()->detach($article->id);
            $article->decrement('collect_count');
            return response()->json(['status' => 200, 'action' => 'down']);
        }else{
            $user->collects()->attach($article->id);
            $article->increment('collect_count');
            Auth::user()->histories()->create([
                'type' => 'collect',
                'content' => '收藏文章《<a href="/article/'.$article->id.'" target="_blank">'.$article->title.'</a>》'
            ]);
            return response()->json(['status' => 200, 'action' => 'up']);
        }
    }

    public function upload(Request $request)
    {
        $input = $request->all();
        $file_path = $message = '';
        $success = false;

        if (!$request->user()->can('image.upload')){
            return response('您没有权限上传图片', 401);
        }

        $rules = array(
            'file' => 'image|max:2000',
        );

        $validation = Validator::make($input, $rules);

        if ($validation->fails()) {
            $message = '文件格式不正确';
            $data = array(
                'success' => $success,
                'msg' => $message,
                'file_path'=> $file_path
            );
            return response()->json($data);
        }
        $path = 'uploads/' . Auth::user()->id . '/' . date('Ym');

        try{
            // File Upload
            if ($request->hasFile('file')){
                $pic = $request->file('file');

                if($pic->isValid()){
                    $newName = date('Ymd').'-'.md5(rand(1,1000).$pic->getClientOriginalName()).".".$pic->getClientOriginalExtension();
                    $fileSize = $pic->getClientSize();
                    $request->file('file')->move($path, $newName);
                    $success = true;
                    $message = 'Upload Success';
                    $file_path = '/'.$path.'/'.$newName;
                    Image::create([
                        'user_id' => $this->currentUser->id,
                        'name' => $newName,
                        'url' => $file_path,
                        'size' => $fileSize
                    ]);
                }else{
                    $message = 'The file is invalid';
                }
            }else{
                $message = 'No File';
            }
        }catch (\Exception $e){
            $message = $e->getMessage();
        }

        $data = array(
            'success' => $success,
            'msg' => $message,
            'file_path'=> $file_path
        );
        return response()->json($data);
    }

    public function forUser(Request $request, $uid){
        $user = User::findOrFail($uid);
        $articles = $this->articles->forUser($uid);
        return view('articles.user', compact('articles', 'user'));
    }

}
