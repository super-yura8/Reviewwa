<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReqisterRequest extends FormRequest
{
    const REG_PASS = '/(?=.*[0-9])(?!.*[!@#$%^&*-])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,}/';
    const REG_LOG = '/^[a-zA-Z][a-zA-Z0-9-_\.]{1,30}$/';
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
            'name' => 'required|string|max:30|regex:'.self::REG_LOG,
            'email' =>'required|email|max:255',
            'password' => 'required|string|max:60|min:7|regex:'.self::REG_PASS,
            'password_again'=> 'required|string|max:60|min:7|regex:'.self::REG_PASS,
        ];
    }

    /**
     * replaces en words to ru
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'имя',
            'password' => 'пароль',
            'passwordAgain' => 'повторите пароль',
        ];
    }
}
