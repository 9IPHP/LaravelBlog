<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
Use App\Article;
Use App\Comment;
Use App\User;
Use Auth;
use Validator;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*protected function validator(array $data)
    {
        return Validator::make($data, [
            'body' => 'required',
        ]);
    }*/

    public function store(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        /*$rules = array(
            'body' => 'required',
        );
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            redirect()->back()->withInput();
        }*/
        $data = ['article_id' => $id, 'user_id' => Auth::id(), 'body' => $request->body];
        Comment::create($data);
        redirect('/article/'.$id);
        // dd($request->body);
    }
}
