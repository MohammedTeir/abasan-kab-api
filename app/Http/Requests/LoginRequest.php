<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                Rule::exists('admins', 'email')->where(function ($query) {
                    $query->where('status', 'active');
                }),
            ],
            'password' => 'required|string|min:5',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.string' => 'حقل البريد الإلكتروني يجب أن يكون نصًا.',
            'email.email' => 'يجب أن يكون حقل البريد الإلكتروني عنوان بريد إلكتروني صالح.',
            'email.exists' => 'البريد الإلكتروني المدخل غير مسجل أو الحساب مقيد.',
            'password.required' => 'حقل كلمة المرور مطلوب.',
            'password.string' => 'حقل كلمة المرور يجب أن يكون نصًا.',
            'password.min' => 'يجب أن تتكون كلمة المرور على الأقل من 5 أحرف.',
        ];
    }
}
