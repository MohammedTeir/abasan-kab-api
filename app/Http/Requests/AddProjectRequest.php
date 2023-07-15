<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddProjectRequest extends FormRequest
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
            'title' => 'required|string',
            'content' => 'required|string',
            'category_id' => 'required|exists:municipality_projects_categories,id',
            'project_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
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
            'title.required' => 'حقل العنوان مطلوب.',
            'content.required' => 'حقل المحتوى مطلوب.',
            'category_id.required' => 'حقل رقم الفئة مطلوب.',
            'category_id.exists' => 'تم اختيار رقم فئة غير صالح.',
            'project_images.*.image' => 'يجب أن يكون ملف الصورة من نوع صورة.',
            'project_images.*.mimes' => 'يجب أن يكون ملف الصورة من نوع: jpeg, png, jpg, gif.',
            'project_images.*.max' => 'يجب ألا يتجاوز حجم ملف الصورة :max كيلوبايت.',
        ];
    }


}
