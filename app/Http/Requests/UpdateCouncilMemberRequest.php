<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCouncilMemberRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:255',
            'cv_file' => 'nullable|file|mimes:pdf|max:2048',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }


    /**
     * Get custom error messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'يرجى إدخال اسم العضو.',
            'name.string' => 'يجب أن يكون اسم العضو نصًا.',
            'name.max' => 'يجب ألا يتجاوز اسم العضو 255 حرفًا.',
            'position.required' => 'يرجى إدخال منصب العضو.',
            'position.string' => 'يجب أن يكون منصب العضو نصًا.',
            'position.max' => 'يجب ألا يتجاوز منصب العضو 255 حرفًا.',
            'mobile_number.required' => 'يرجى إدخال رقم الجوال.',
            'mobile_number.string' => 'يجب أن يكون رقم الجوال نصًا.',
            'mobile_number.max' => 'يجب ألا يتجاوز رقم الجوال 255 حرفًا.',
            'cv_file.file' => 'يجب أن يكون ملف السيرة الذاتية من نوع ملف.',
            'cv_file.mimes' => 'يجب أن يكون ملف السيرة الذاتية من نوع PDF.',
            'cv_file.max' => 'يجب أن لا يتجاوز حجم ملف السيرة الذاتية 2048 كيلوبايت.',
            'image_file.image' => 'يجب أن تكون صورة العضو من نوع صورة.',
            'image_file.mimes' => 'يجب أن تكون صورة العضو من نوع JPEG أو PNG أو JPG.',
            'image_file.max' => 'يجب ألا يتجاوز حجم صورة العضو 2048 كيلوبايت.',
        ];
    }

}
