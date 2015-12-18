<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserRepository $users)
    {
        $this->middleware('auth', ['only' => ['edit', 'update']]);
        $this->users = $users;
        view()->share('currentUser', Auth::user());
    }

    public function index()
    {
        $users = User::orderBy('created_at', 'DESC')->get();
        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('users.user', compact('user'));
    }

    public function articles($id)
    {
        $user = User::findOrFail($id);
        $currentUser = Auth::user();
        if($currentUser && $currentUser->id == $id)
            $articles = $user->articles()->recent()->simplePaginate(10);
        else
            $articles = $user->articles()->actived()->recent()->simplePaginate(10);
        return view('users.articles', compact('user', 'articles'));
    }

    public function collects($id)
    {
        $user = User::findOrFail($id);
        $articles = $user->collects()->simplePaginate(10);
        // dd($articles->pivot->created_at);
        return view('users.collects', compact('user', 'articles'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(User $user, UserRequest $request)
    {
        $this->authorize('update', $user);
        $data = $request->only(['nickname', 'website', 'weibo', 'qq', 'github', 'description']);
        $user->update($data);
        flash()->message('修改成功！');
        return redirect('user/' . $user->id . '/edit');
    }
}
