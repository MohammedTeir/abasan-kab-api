<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAlbumRequest extends FormRequest
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
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif',
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
            'title.required' => ' العنوان مطلوب.',
            'images.*.image' => 'يجب أن تكون الصورة صورة صحيحة.',
            'images.*.mimes' => 'صيغ الملفات المسموح بها هي jpeg، png، jpg، gif فقط.',
        ];
    }

}
