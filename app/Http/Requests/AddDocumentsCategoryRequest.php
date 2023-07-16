<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddDocumentsCategoryRequest extends FormRequest
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
        return [
            'name' => 'required|string|unique:document_categories',
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
