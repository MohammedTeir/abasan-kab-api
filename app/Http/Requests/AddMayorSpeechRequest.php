<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddMayorSpeechRequest extends FormRequest
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
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => ' العنوان مطلوب.',
            'content.required' => ' المحتوى مطلوب.',
            'image.required' => ' الصورة مطلوب.',
            'image.image' => 'يجب أن يكون الملف المحدد صورة.',
            'image.mimes' => 'يجب أن يكون نوع الملف صورة بامتدادات jpeg، png، jpg، gif.',
            'image.max' => 'يجب ألا يتجاوز حجم الملف 2048 كيلوبايت.',
        ];
    }


}
