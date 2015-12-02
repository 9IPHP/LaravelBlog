<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return $users;
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return $user;
    }

    public function articles($id)
    {
        $user = User::findOrFail($id);
        // $articles = Article::whose($id)->actived()->recent()->get();
        $articles = $user->articles()->actived()->recent()->simplePaginate(10);
        // dd($articles);
        return view('articles.user', compact('user', 'articles'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return $user;
    }
}
