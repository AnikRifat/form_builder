<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormFieldRequest;
use App\Http\Requests\UpdateFormFieldRequest;
use App\Models\Form;
use App\Models\FormField;

class FormFieldController extends Controller
{
    /**
     * Store a newly created form field in storage.
     */
    public function store(StoreFormFieldRequest $request, Form $form)
    {
        $form->fields()->create($request->validated());

        return response()->json(['message' => 'Field created successfully']);
    }

    /**
     * Update the specified form field in storage.
     */
    public function update(UpdateFormFieldRequest $request, Form $form, FormField $field)
    {
        $field->update($request->validated());

        return response()->json(['message' => 'Field updated successfully']);
    }

    /**
     * Remove the specified form field from storage.
     */
    public function destroy(Form $form, FormField $field)
    {
        $field->delete();

        return response()->json(['message' => 'Field deleted successfully']);
    }
}
