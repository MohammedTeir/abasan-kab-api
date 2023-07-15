<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddViedoRequest extends FormRequest
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
            'embed_code' => 'required',
        ];
    }

    /**
     * Get the validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'حقل العنوان مطلوب.',
            'embed_code.required' => 'حقل رمز الفيديو مطلوب.',
        ];
    }
}
