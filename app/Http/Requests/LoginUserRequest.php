<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
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
            'email' => 'required|string',
            'password' => 'required|string',
        ];
    }

    public function messages()
    {
        return $messages = [
        'email.required' => 'Значение поля :attribute не может быть пустым',
        'email.string' => 'Значение поля :attribute должно быть строкой',
        'password.required' => 'Значение поля :attribute не может быть пустым',
        'password.string' => 'Значение поля :attribute должно быть строкой',


        ];
    }
}
