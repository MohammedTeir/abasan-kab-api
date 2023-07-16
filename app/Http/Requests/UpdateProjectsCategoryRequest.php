<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectsCategoryRequest extends FormRequest
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
        $categoryId = $this->route('project_category');

        return [
            'name' => [
                'required',
                'string',
                Rule::unique('municipality_projects_categories')->ignore($categoryId),
            ],
        ];
    }

        /**
     * Get the error messages for the defined validation rules.
     */
    public function messages()
    {
        return [
            'name.required' => ' الاسم مطلوب.',
            'name.string' => ' الاسم يجب أن يكون نصًا.',
            'name.unique' => 'الاسم مستخدم بالفعل.',
        ];
    }
}
