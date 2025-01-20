<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFormFieldRequest extends StoreFormFieldRequest
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            // Additional rules for update if needed
        ]);
    }
}
