<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class UpdateProfileRequest extends FormRequest
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
    public function rules(): array
    {
        $user = Auth::user();

        return [
            'name' => 'nullable|string|max:255',
            'email' => [
                'nullable',
                'string',
                'email',
                Rule::unique('admins', 'email')->ignore($user),
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'max:255',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
        ];
    }

    public function messages()
    {

        return [
            'name.string' => ' الاسم يجب أن يكون نصًا.',
            'name.max' => ' الاسم يجب ألا يتجاوز 255 حرفًا.',
            'email.string' => ' البريد الإلكتروني يجب أن يكون نصًا.',
            'email.email' => 'يجب أن يكون  البريد الإلكتروني عنوان بريد إلكتروني صالح.',
            'email.unique' => 'قيمة  البريد الإلكتروني مستخدمة بالفعل.',
            'password.required' => ' كلمة المرور مطلوب.',
            'password.string' => ' كلمة المرور يجب أن يكون نصًا.',
            'password.min' => 'يجب أن تتكون كلمة المرور على الأقل من 8 أحرف.',
            'password.max' => 'يجب ألا تتجاوز كلمة المرور 255 حرفًا.',
            'password.different' => 'يجب أن تكون كلمة المرور مختلفة عن كلمة المرور الحالية.',
            'password.regex' => 'يجب أن تحتوي كلمة المرور على حروف صغيرة وأرقام ورموز.',
        ];


    }






}
