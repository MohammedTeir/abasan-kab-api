<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddMunicipalityAboutRequest extends FormRequest
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
            'content' => 'nullable',
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
            'image.image' => 'يجب أن يكون الملف ملف صورة.',
            'image.mimes' => 'يجب أن يكون الصورة بصيغة صحيحة: jpeg، png، jpg، gif.',
            'image.max' => 'يجب ألا يتجاوز حجم الصورة 2048 كيلوبايت.',
        ];
    }
}
