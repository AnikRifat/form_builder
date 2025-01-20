<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormField;
use App\Http\Requests\StoreFormFieldRequest;
use App\Http\Requests\UpdateFormFieldRequest;
use Illuminate\Http\JsonResponse;

class FormFieldController extends Controller
{
    /**
     * Display a listing of the form fields.
     */
    public function index(Form $form): JsonResponse
    {
        $fields = $form->fields()->orderBy('order')->get();
        return response()->json($fields);
    }

    /**
     * Store a newly created form field in storage.
     */
    public function store(StoreFormFieldRequest $request, Form $form): JsonResponse
    {
        $field = $form->fields()->create($request->validated());
        return response()->json($field, 201);
    }

    /**
     * Update the specified form field in storage.
     */
    public function update(UpdateFormFieldRequest $request, Form $form, FormField $field): JsonResponse
    {
        $field->update($request->validated());
        return response()->json($field);
    }

    /**
     * Remove the specified form field from storage.
     */
    public function destroy(Form $form, FormField $field): JsonResponse
    {
        $field->delete();
        return response()->json(null, 204);
    }
}
