<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Article;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\Validator;

use App\Repositories\ArticleRepository;

class ArticleController extends Controller
{
    protected $articles;
    public function __construct(ArticleRepository $articles)
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->articles = $articles;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $articles = $this->articles->all($request->user());
        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articles.create');
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
        $slug = $requests['slug'] ? $requests['slug'] : baidu_translate($requests['title']);
        $requests['slug'] = str_slug($slug);
        $requests['excerpt'] = $requests['excerpt'] ? $requests['excerpt'] : mb_content_filter_cut($requests['body']);
        // dd($requests);
        if (empty($requests['slug']))
            return redirect()->back()->withErrors(array('Slug is required!'))->withInput();
        $article = new Article($requests);
        Auth::user()->articles()->save($article);
        return redirect('/articles');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $article = Article::whereSlug($slug)->actived()->firstOrFail();
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function upload(Request $request)
    {
        $input = $request->all();
        $file_path = $message = '';
        $success = false;

        $rules = array(
            'file' => 'image|max:2000',
        );

        $validation = Validator::make($input, $rules);

        if ($validation->fails()) {
            $data = array(
                'status' => $success,
                'message' => $message,
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
                    $newName = md5(rand(1,1000).$pic->getClientOriginalName()).".".$pic->getClientOriginalExtension();
                    $request->file('file')->move($path, $newName);
                    $success = true;
                    $message = 'Upload Success';
                    $file_path = '/'.$path.'/'.$newName;
                }else{
                    $message = 'The file is invalid';
                }
            }else{
                $message = 'No File';
            }
        }catch (\Exception $e){
            $message = $e->getMessage();
            // self::addError($e->getMessage());
        }

        $data = array(
            'status' => $success,
            'message' => $message,
            'file_path'=> $file_path
        );
        return response()->json($data);
    }
}
