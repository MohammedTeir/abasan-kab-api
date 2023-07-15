<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCoverImagesRequest extends FormRequest
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
            'cover_images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            'cover_images.*.required' => 'حقل الصورة مطلوب.',
            'cover_images.*.image' => 'يجب أن يكون الملف المحدد صورة.',
            'cover_images.*.mimes' => 'يجب أن يكون نوع الملف صورة بامتدادات jpeg، png، jpg، gif.',
            'cover_images.*.max' => 'يجب ألا يتجاوز حجم الملف 2048 كيلوبايت.',
        ];
    }

}
