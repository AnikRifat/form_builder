<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        dd($this->all());
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'method' => 'required|string|in:GET,POST,PUT,PATCH,DELETE',
            'action' => 'required|string|max:255',
            'is_active' => 'boolean',
            'fields' => 'nullable|array',
            'fields.*.type' => 'required|string|in:text,email,textarea,select,checkbox,radio',
            'fields.*.name' => 'required|string|max:255',
            'fields.*.label' => 'required|string|max:255',
            'fields.*.placeholder' => 'nullable|string|max:255',
            'fields.*.is_required' => 'boolean',
            'fields.*.validation_rules' => 'nullable|array',
            'fields.*.options' => 'nullable|array',
            'fields.*.order' => 'required|integer'
        ];
    }
}
