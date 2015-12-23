<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Article;
use App\Comment;
use App\Repositories\ArticleRepository;

class ArticleController extends BaseController
{
    protected $articles;

    public function __construct(ArticleRepository $articles)
    {
        $this->articles = $articles;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orderby = $request->orderby ? $request->orderby : 'created_at';


        $articles =  Article::with('user')
                    ->Orderby($orderby, 'DESC')
                    ->simplePaginate(10);
        // $articles = $this->articles->allWithNotActived();
        return view('admin.articles.index', compact('articles', 'orderby'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::find($id, ['id' ,'user_id']);
        if (empty($article)) {
            return response()->json(404);
        }
        // delete tags
        $this->articles->delTags($article);
        // TODO: delete comments
        // Comment::where('article_id', $article->id)->delete();
        // TODO: Notice User of Article Delete

        // delete article
        $article->delete();
        return response()->json(200);
    }

    public function trash()
    {
        $articles = $this->articles->onlyDeleted();
        return view('admin.articles.trash', compact('articles'));
    }

    public function forceDestroy($id)
    {
        $article = Article::onlyTrashed()->find($id, ['id' ,'user_id']);
        // return response()->json($article);
        if (empty($article)) {
            return response()->json(404);
        }
        // delete comments
        Comment::where('article_id', $article->id)->delete();

        // delete article
        $article->forceDelete();
        return response()->json(200);
    }

    public function forceDestroyAll(Request $request)
    {
        return response()->json($request->all());
        dd($request);
    }
}
