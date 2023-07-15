<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentRequest extends FormRequest
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
            'name' => 'nullable|string',
            'document' => 'nullable|file|mimes:pdf,doc,docx',
            'document_category_id' => 'nullable|exists:document_categories,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages()
    {
        return [
            'name.string' => 'يجب أن يكون حقل الاسم نصًا.',
            'document.file' => 'يجب أن يكون حقل المستند ملفًا.',
            'document.mimes' => 'يجب أن يكون نوع المستند صالحًا. يجب أن يكون الامتدادات المسموح بها: pdf, doc, docx.',
            'document_category_id.exists' => 'قيمة فئة المستند غير صالحة.',
        ];
    }
}
