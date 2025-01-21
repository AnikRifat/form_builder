<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormFieldRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type' => 'required|string|in:text,email,textarea,select,checkbox,radio',
            'name' => 'required|string|max:255',
            'label' => 'required|string|max:255',
            'placeholder' => 'nullable|string|max:255',
            'is_required' => 'boolean',
            'options' => 'nullable|array',
            'order' => 'required|integer',
        ];
    }
}
