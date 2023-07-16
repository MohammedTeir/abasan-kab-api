<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddNewsRequest extends FormRequest
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
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'news_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'nullable|string',
        ];
    }

    /**
     * Get the validation messages for the request.
     */

    public function messages(): array
    {
        return [
            'title.required' => ' العنوان مطلوب.',
            'content.required' => ' المحتوى مطلوب.',
            'is_featured.boolean' => 'يجب أن يكون  الإعلان المميز قيمة منطقية (boolean).',
            'is_published.boolean' => 'يجب أن يكون  النشر قيمة منطقية (boolean).',
            'news_images.*.image' => 'يجب أن يكون الملف المرسل للصورة صورة.',
            'news_images.*.mimes' => 'يجب أن يكون الملف المرسل للصورة من نوع: jpeg, png, jpg, gif.',
            'news_images.*.max' => 'يجب ألا يتجاوز حجم الملف المرسل للصورة 2048 كيلوبايت.',
            'tags.string' => 'يجب أن يكون  الوسوم نصًا.',
        ];
    }
}
