<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddServiceRequest extends FormRequest
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
            'service_name' => 'required|string|max:255|unique:services',
            'price' => 'required|string',
            'required_time' => 'required|string',
            'required_documents' => 'nullable|string',
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
            'service_category_id.required' => 'حقل معرف فئة الخدمة مطلوب.',
            'service_category_id.exists' => 'معرف فئة الخدمة غير صالح.',
            'service_name.required' => 'حقل اسم الخدمة مطلوب.',
            'service_name.string' => 'حقل اسم الخدمة يجب أن يكون نصًا.',
            'service_name.max' => 'حقل اسم الخدمة يجب ألا يتجاوز 255 حرفًا.',
            'service_name.unique' => 'اسم الخدمة مستخدم بالفعل.',
            'price.required' => 'حقل السعر مطلوب.',
            'price.string' => 'حقل السعر يجب أن يكون نصًا.',
            'required_time.required' => 'حقل الوقت المطلوب مطلوب.',
            'required_time.string' => 'حقل الوقت المطلوب يجب أن يكون نصًا.',
            'required_documents.string' => 'حقل الوثائق المطلوبة يجب أن يكون نصًا.',
        ];
    }
}
