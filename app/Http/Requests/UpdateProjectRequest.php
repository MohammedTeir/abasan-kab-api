<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            'title' => 'nullable|string',
            'content' => 'nullable|string',
            'category_id' => 'nullable|exists:municipality_projects_categories,id',
            'project_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            'title.string' => 'حقل العنوان يجب أن يكون نصًا.',
            'content.string' => 'حقل المحتوى يجب أن يكون نصًا.',
            'category_id.exists' => 'تم اختيار رقم الفئة غير صالح.',
            'project_images.*.image' => 'يجب أن يكون ملف الصورة من نوع صورة.',
            'project_images.*.mimes' => 'يجب أن يكون ملف الصورة من نوع: jpeg, png, jpg, gif.',
            'project_images.*.max' => 'يجب ألا يتجاوز حجم ملف الصورة :max كيلوبايت.',
        ];
    }
}
