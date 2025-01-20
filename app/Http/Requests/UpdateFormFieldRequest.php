<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFormFieldRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'sometimes|string|in:text,email,textarea,select,checkbox,radio',
            'name' => 'sometimes|string|max:255|regex:/^[a-zA-Z_][a-zA-Z0-9_]*$/',
            'label' => 'sometimes|string|max:255',
            'placeholder' => 'nullable|string|max:255',
            'is_required' => 'sometimes|boolean',
            'validation_rules' => 'nullable|array',
            'options' => 'nullable|array',
            'order' => 'sometimes|integer'
        ];
    }
}
