<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class ChangeFormRequest extends AddUserFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
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
        ];
    }
}
