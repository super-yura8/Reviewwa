<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordChangeRequest extends FormRequest
{
    const REG_PASS = '/(?=.*[0-9])(?!.*[!@#$%^&*-])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,}/';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'originPass' => 'required|string|max:60|min:7|regex:'.self::REG_PASS,
            'pass' => 'required|string|max:60|min:7|regex:'.self::REG_PASS,
            'passAgg'=> 'required|string|max:60|min:7|regex:'.self::REG_PASS,
        ];
    }
}
