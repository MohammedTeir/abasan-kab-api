<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddSettingRequest extends FormRequest
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
            'telephone_number' => 'required',
            'mobile_number' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'youtube' => 'nullable|url',
            'cover_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            'telephone_number.required' => 'حقل رقم الهاتف مطلوب.',
            'mobile_number.required' => 'حقل رقم الجوال مطلوب.',
            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.email' => 'يجب أن يكون البريد الإلكتروني صالحًا.',
            'address.required' => 'حقل العنوان مطلوب.',
            'facebook.url' => 'يجب أن يكون حقل الفيسبوك رابطًا صالحًا.',
            'instagram.url' => 'يجب أن يكون حقل الإنستجرام رابطًا صالحًا.',
            'youtube.url' => 'يجب أن يكون حقل اليوتيوب رابطًا صالحًا.',
            'cover_images.*.image' => 'يجب أن يكون الملف المحدد صورة.',
            'cover_images.*.mimes' => 'يجب أن يكون نوع الملف صورة بامتدادات jpeg، png، jpg، gif.',
            'cover_images.*.max' => 'يجب ألا يتجاوز حجم الملف 2048 كيلوبايت.',
        ];
    }
}
