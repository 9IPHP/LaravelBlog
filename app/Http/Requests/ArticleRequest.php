<?php

namespace App\Http\Requests;

use App\Article;
use App\Http\Requests\Request;
use Illuminate\Http\Request as Requests;

class ArticleRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Requests $request)
    {
        $segment = $request->segment(2);
        $req_slug = $request->get('slug');
        $id = ($segment == $req_slug ? ','.Article::whereSlug($req_slug)->first()->id : '');
        return [
            'title' => 'required|min:3',
            'slug' => 'alpha_dash|min:3',
            'slug' => 'alpha_dash|min:3|unique:articles,slug'.$id,
            // 'excerpt' => 'required',
            'body' => 'required',
            'is_active' => 'boolean',
            'comment_status' => 'boolean',
        ];
    }
}
