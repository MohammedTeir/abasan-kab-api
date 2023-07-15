<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddAlbumRequest extends FormRequest
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
            'description' => 'nullable',
            'images.*' => 'required|mimes:jpeg,png,jpg,gif',
        ];
    }

    /**
     * Get the validation messages in Arabic.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'حقل العنوان مطلوب.',
            'images.*.required' => 'حقل الصور مطلوب.',
            'images.*.mimes' => 'صيغ الملفات المسموح بها هي jpeg، png، jpg، gif فقط.',
        ];
    }
}
