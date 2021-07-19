<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServicesRequest extends FormRequest
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
            'name' => 'required',
            'status' => 'in:1,2',
            'description' => 'required',
           // 'image' => 'required',
            'content' => 'array|min:1', //[]
            'content.*' => 'required',
        ];
    }
}
