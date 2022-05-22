<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthUserRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ];
    }

    public function messages()
    {
        return $messages = [
        'name.required' => 'Значение поля :attribute не может быть пустым',
        'name.string' => 'Значение поля :attribute должно быть строкой',
        'email.required' => 'Значение поля :attribute не может быть пустым',
        'email.string' => 'Значение поля :attribute должно быть строкой',
        'email.unique' => 'Пользователь с таким :attribute уже зарегистрирован в системе',
        'password.required' => 'Значение поля :attribute не может быть пустым',
        'password.string' => 'Значение поля :attribute должно быть строкой',
        'password.confirmed' => 'Пароли не совпадают',

        ];
    }
}
