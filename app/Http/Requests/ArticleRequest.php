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
        $rules = [
            'title' => 'required|min:3',
            // 'excerpt' => 'required',
            'body' => 'required',
            'comment_status' => 'boolean',
            'tag_list' => 'array',
        ];

        if(is_array($this->request->get('tag_list')) && !empty($this->request->get('tag_list'))) foreach($this->request->get('tag_list') as $key => $val)
        {
            $rules['tag_list.'.$key] = 'regex:/^[a-zA-Z0-9\x{4e00}-\x{9fa5}-_]+$/iu';
        }

        return $rules;
    }
}
