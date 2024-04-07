<?php

namespace App\Http\Requests\Auth;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    use ApiResponse;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        ];
    }


    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->errorResponse(422, $validator->errors()));
    }

    public function messages()
    {
        return [
            'password.regex' => 'فرمت رمز عبور باید بالای 6 کاراکتر و شامل حروف کوچک و بزرگ انگلیسی، اعداد و کاراکتر ویژه باشد'
        ];
    }
}
