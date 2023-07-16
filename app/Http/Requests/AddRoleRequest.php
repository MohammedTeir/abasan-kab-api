<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddRoleRequest extends FormRequest
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
            'role_name' => 'required|string|max:255|unique:roles,name',
            'description' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'role_name.required' => ' اسم الدور مطلوب.',
            'role_name.string' => ' اسم الدور يجب أن يكون نصًا.',
            'role_name.max' => ' اسم الدور يجب ألا يتجاوز 255 حرفًا.',
            'role_name.unique' => 'قيمة  اسم الدور مستخدمة بالفعل.',
            'description.string' => ' الوصف يجب أن يكون نصًا.',
        ];
    }

}
