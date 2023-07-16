<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class AddAdminRequest extends FormRequest
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
            'avatar' => 'required|image|max:2048|mimetypes:image/*',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email|max:255',
            'password' => 'required|string|min:8|max:255|confirmed',
            'password_confirmation' => 'required|string',
            'role_id' => 'required|string|max:255|exists:roles,id',
        ];
    }

    public function messages()
    {
        return [
            'avatar.required' => ' الصورة مطلوب.',
            'avatar.image' => 'يجب أن يكون ال صورة.',
            'avatar.max' => 'يجب أن لا يتجاوز حجم الصورة 2048 كيلوبايت.',
            'avatar.mimetypes' => 'يجب أن تكون الصورة من نوع ملف الصورة.',
            'full_name.required' => ' الاسم الكامل مطلوب.',
            'full_name.string' => 'يجب أن يكون  الاسم الكامل نصًا.',
            'full_name.max' => 'يجب أن لا يتجاوز حجم الاسم الكامل 255 حرفًا.',
            'email.required' => ' البريد الإلكتروني مطلوب.',
            'email.email' => 'يجب أن يكون  البريد الإلكتروني صالحًا.',
            'email.unique' => 'قيمة  البريد الإلكتروني مستخدمة بالفعل.',
            'email.max' => 'يجب أن لا يتجاوز حجم البريد الإلكتروني 255 حرفًا.',
            'password.required' => ' كلمة المرور مطلوب.',
            'password.string' => 'يجب أن تكون كلمة المرور نصًا.',
            'password.min' => 'يجب أن تحتوي كلمة المرور على الأقل 8 أحرف.',
            'password.max' => 'يجب ألا تتجاوز كلمة المرور 255 حرفًا.',
            'password.confirmed' => ' تأكيد كلمة المرور غير متطابق.',
            'password_confirmation.required' => ' تأكيد كلمة المرور مطلوب.',
            'role_id.required' => ' الدور مطلوب.',
            'role_id.string' => 'يجب أن يكون  الدور نصًا.',
            'role_id.max' => 'يجب أن لا يتجاوز حجم الدور 255 حرفًا.',
            'role_id.exists' => 'قيمة  الدور غير صالحة.',
        ];
}



}
