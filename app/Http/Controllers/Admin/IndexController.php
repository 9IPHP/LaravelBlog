<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Image;
use App\Article;
use App\Tag;

class IndexController extends BaseController
{
    public function index()
    {
        $userCount = User::count();
        $articleCount = Article::count();
        $tagCount = Tag::count();
        $imageCount = Image::count();
        return view('admin.index', compact('userCount', 'articleCount', 'imageCount', 'tagCount'));
    }
}
