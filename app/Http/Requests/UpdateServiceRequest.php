<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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
            'service_category_id' => 'required|exists:service_categories,id',
            'service_name' => 'required|string|max:255',
            'price' => 'required|string',
            'required_time' => 'required|string',
            'required_documents' => 'required|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'service_category_id.required' => 'حقل تصنيف الخدمة مطلوب.',
            'service_category_id.exists' => 'تصنيف الخدمة المحدد غير صالح.',
            'service_name.required' => 'حقل اسم الخدمة مطلوب.',
            'service_name.string' => 'يجب أن يكون اسم الخدمة نصًا.',
            'service_name.max' => 'لا يجب أن يتجاوز اسم الخدمة :max حرفًا.',
            'price.required' => 'حقل السعر مطلوب.',
            'price.string' => 'يجب أن يكون السعر نصًا.',
            'required_time.required' => 'حقل الوقت المطلوب مطلوب.',
            'required_time.string' => 'يجب أن يكون الوقت المطلوب نصًا.',
            'required_documents.required' => 'حقل الوثائق المطلوبة مطلوب.',
            'required_documents.string' => 'يجب أن تكون الوثائق المطلوبة نصًا.',
        ];
    }
}


