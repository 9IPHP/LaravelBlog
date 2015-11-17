<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Tag;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $tags = Tag::where('count', '>', 0)->orderBy('count', 'desc')->get();
        return view('articles.tags', compact('tags'));
    }

    public function show($slug)
    {
        $tag = Tag::whereSlug($slug)->firstOrFail();
        $articles = $tag->articles()->simplePaginate(1);
        // dd($articles);
        return view('articles.tag', compact('tag', 'articles'));
        // dd(Tag::whereSlug($slug)->firstOrFail()->toArray());
        dd($this->articles->toArray());
    }
}
