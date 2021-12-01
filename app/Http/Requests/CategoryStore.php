<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStore extends FormRequest
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
            'name' => 'required|unique:categories|max:255',
            'paren_id' => 'required|integer',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'A name is required',
            'paren_id.required' => 'A paren_id is required',
        ];
    }
}