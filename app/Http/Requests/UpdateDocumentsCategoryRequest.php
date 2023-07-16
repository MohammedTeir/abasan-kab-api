<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDocumentsCategoryRequest extends FormRequest
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
        $categoryId = $this->route('document_category');

        return [
            'name' => [
                'required',
                'string',
                Rule::unique('document_categories')->ignore($categoryId),
            ],
        ];

    }

    /**
     * Get the validation messages for the request.
     */
    public function messages()
    {
        return [
            'name.required' => ' الاسم مطلوب.',
            'name.string' => ' الاسم يجب أن يكون نصًا.',
            'name.unique' => 'قيمة الاسم موجودة بالفعل.',
        ];
    }

}
