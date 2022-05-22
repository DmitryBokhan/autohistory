<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'slug' => 'required',
            'balance' => 'required',
        ];
    }

    public function messages()
    {
        return $messages = [
        'name.required' => 'Значение поля :attribute не может быть пустым',
        'slug.required' => 'Значение поля :attribute не может быть пустым',
        'balance.required' => 'Значение поля :attribute не может быть пустым',
        ];
}
}
