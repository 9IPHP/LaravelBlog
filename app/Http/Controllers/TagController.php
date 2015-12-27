<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Tag;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    public function __construct()
    {
        // $this->middleware('level:5');
    }
    public function index(Request $request)
    {
        $tags = Tag::where('count', '>', 0)->get();
        $tagLists = [];
        foreach ($tags as $tag) {
            $tagLists[$tag['letter']][] = $tag;
        }
        $Unknown = [];
        if(isset($tagLists['Unknown'])){
            $Unknown = $tagLists['Unknown'];
            unset($tagLists['Unknown']);
        }
        ksort($tagLists);
        if($Unknown) $tagLists['Unknown'] = $Unknown;
        return view('articles.tags', compact('tagLists'));
    }

    public function show($slug)
    {
        $tag = Tag::whereSlug($slug)->firstOrFail();
        $articles = $tag->articles()->orderBy('created_at', 'desc')->simplePaginate(10);
        return view('articles.tag', compact('tag', 'articles'));
    }
}
