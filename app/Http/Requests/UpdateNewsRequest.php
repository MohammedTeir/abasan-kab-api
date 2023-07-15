<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsRequest extends FormRequest
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
            'is_featured' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
            'news_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'nullable|string',
        ];
    }

    /**
     * Get the validation messages for the rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.string' => 'حقل العنوان يجب أن يكون نصًا.',
            'content.string' => 'حقل المحتوى يجب أن يكون نصًا.',
            'is_featured.boolean' => 'حقل التمييز يجب أن يكون قيمة منطقية.',
            'is_published.boolean' => 'حقل النشر يجب أن يكون قيمة منطقية.',
            'news_images.*.image' => 'يجب أن يكون الملفات المحددة صورًا.',
            'news_images.*.mimes' => 'الصيغ المسموح بها للصور هي: jpeg، png، jpg، gif.',
            'news_images.*.max' => 'يجب أن يكون حجم الصورة أقل من 2048 كيلوبايت.',
            'tags.string' => ' حقل الوسوم يجب أن يكون نصًا. مع وضع , بين كل وسم',
        ];
    }

}
