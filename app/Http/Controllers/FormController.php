<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Http\Requests\StoreFormRequest;
use App\Http\Requests\UpdateFormRequest;
use Illuminate\Http\JsonResponse;

class FormController extends Controller
{
    /**
     * Display a listing of the forms.
     */
    public function index(): JsonResponse
    {
        $forms = Form::with('fields')->get();
        return response()->json($forms);
    }

    /**
     * Store a newly created form in storage.
     */
    public function store(StoreFormRequest $request): JsonResponse
    {
        $form = Form::create($request->validated());
        return response()->json($form, 201);
    }

    /**
     * Display the specified form.
     */
    public function show(Form $form): JsonResponse
    {
        $form->load('fields');
        return response()->json($form);
    }

    /**
     * Update the specified form in storage.
     */
    public function update(UpdateFormRequest $request, Form $form): JsonResponse
    {
        $form->update($request->validated());
        return response()->json($form);
    }

    /**
     * Remove the specified form from storage.
     */
    public function destroy(Form $form): JsonResponse
    {
        $form->delete();
        return response()->json(null, 204);
    }
}
