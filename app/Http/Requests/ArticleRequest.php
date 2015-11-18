<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

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
    public function rules()
    {
        return [
            'title' => 'required|min:3',
            'slug' => 'alpha_dash|min:3',
            'slug' => 'unique:articles|alpha_dash|min:3',
            // 'excerpt' => 'required',
            'body' => 'required',
            'is_active' => 'boolean',
            'comment_status' => 'boolean',
        ];
    }
}
