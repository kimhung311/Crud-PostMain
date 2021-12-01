<?php

namespace App\Http\Requests;

use Dotenv\Validator;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategory extends FormRequest
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
            'name' => 'required|max:255',
            'paren_id' => 'required|integer|min:1|max:11',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'A name is required',
            'paren_id.required' => 'Vui lòng nhập number',
        ];
    }
}