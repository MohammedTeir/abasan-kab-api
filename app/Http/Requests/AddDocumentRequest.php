<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddDocumentRequest extends FormRequest
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
            'name' => 'required|string',
            'document' => 'required|file|mimes:pdf,doc,docx',
            'document_category_id' => 'required|exists:document_categories,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages()
    {
        return [
            'name.required' => ' الاسم مطلوب.',
            'name.string' => 'يجب أن يكون  الاسم نصًا.',
            'document.required' => ' المستند مطلوب.',
            'document.file' => 'يجب أن يكون  المستند ملفًا.',
            'document.mimes' => 'يجب أن يكون نوع المستند صالحًا. يجب أن يكون الامتدادات المسموح بها: pdf, doc, docx.',
            'document_category_id.required' => ' فئة المستند مطلوب.',
            'document_category_id.exists' => 'قيمة فئة المستند غير صالحة.',
        ];
    }
}
