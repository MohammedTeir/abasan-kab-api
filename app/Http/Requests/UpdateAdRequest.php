<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdRequest extends FormRequest
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            'title.required' => 'يرجى إدخال العنوان.',
            'content.required' => 'يرجى إدخال المحتوى.',
            'image.image' => 'يجب أن يكون الملف المرفق صورة.',
            'image.mimes' => 'يجب أن تكون الصورة بتنسيق JPEG أو PNG أو JPG أو GIF.',
            'image.max' => 'يجب ألا يتجاوز حجم الصورة 2048 كيلوبايت.',
        ];
    }
}
