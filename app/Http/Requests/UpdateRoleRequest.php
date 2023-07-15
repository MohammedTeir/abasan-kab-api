<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
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
        $id = $this->route('role');

        return [
            'role_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($id),
            ],
            'description' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'role_name.required' => 'حقل اسم الدور مطلوب.',
            'role_name.string' => 'حقل اسم الدور يجب أن يكون نصًا.',
            'role_name.max' => 'حقل اسم الدور يجب ألا يتجاوز 255 حرفًا.',
            'role_name.unique' => 'قيمة حقل اسم الدور مستخدمة بالفعل.',
            'description.string' => 'حقل الوصف يجب أن يكون نصًا.',
        ];
    }

}
