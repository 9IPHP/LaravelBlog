<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class NotifyRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->user()->hasRole('admin')) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|integer',
            'body' => 'required',
            'type' => 'required',
            'to_all' => 'required|boolean'
        ];
    }
}
