<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddVacancyRequest extends FormRequest
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
            'title' => 'required',
            'content' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Get the validation error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'يجب تعبئة عنوان الوظيفة.',
            'content.required' => 'يجب تعبئة محتوى الوظيفة.',
            'image.required' => 'يجب تحميل صورة للوظيفة.',
            'image.image' => 'يجب أن تكون الملف المحمل صورة.',
            'image.mimes' => 'يجب أن يكون الملف المحمل من نوع: jpeg, png, jpg, gif.',
            'image.max' => 'يجب أن يكون حجم الملف المحمل أقل من 2MB.',
        ];
    }

}
