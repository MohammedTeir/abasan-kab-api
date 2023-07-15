<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileImageRequest extends FormRequest
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
            'avatar' => [
                'required',
                'image',
                'max:2048',
                'mimetypes:image/*',
            ],
        ];
    }

    public function messages()
    {
        return [
            'avatar.required' => 'حقل الصورة مطلوب.',
            'avatar.image' => 'يجب أن يكون حقل الصورة صورة.',
            'avatar.max' => 'يجب ألا يتجاوز حجم الصورة 2048 كيلوبايت.',
            'avatar.mimetypes' => 'يجب أن يكون حقل الصورة من نوع صورة.',
        ];
    }
}
