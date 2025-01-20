<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Form;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFormRequest;
use App\Http\Requests\UpdateFormRequest;

class FormController extends Controller
{
    /**
     * Display a listing of the forms.
     */
    public function index()
    {
        return Inertia::render('Admin/FormList', [
            'forms' => Form::with('fields')
                ->orderBy('created_at', 'desc')
                ->get()
        ]);
    }

    /**
     * Show the form for creating a new form.
     */
    public function create()
    {
        return Inertia::render('Admin/FormBuilder');
    }

    /**
     * Store a newly created form in storage.
     */
    public function store(StoreFormRequest $request)
    {
        $form = Form::create($request->validated());

        if ($request->has('fields')) {
            $form->fields()->createMany($request->fields);
        }

        return redirect()->route('forms.index')
            ->with('success', 'Form created successfully');
    }

    /**
     * Display the specified form.
     */
    public function show(Form $form)
    {
        return Inertia::render('Admin/FormBuilder', [
            'form' => $form->load('fields')
        ]);
    }

    /**
     * Show the form for editing the specified form.
     */
    public function edit(Form $form)
    {
        return Inertia::render('Admin/FormBuilder', [
            'form' => $form->load('fields')
        ]);
    }

    /**
     * Update the specified form in storage.
     */
    public function update(UpdateFormRequest $request, Form $form)
    {
        $form->update($request->validated());

        // Sync form fields
        if ($request->has('fields')) {
            $form->fields()->delete();
            $form->fields()->createMany($request->fields);
        }

        return redirect()->route('forms.index')
            ->with('success', 'Form updated successfully');
    }

    /**
     * Remove the specified form from storage.
     */
    public function destroy(Form $form)
    {
        $form->delete();
        return redirect()->route('forms.index')
            ->with('success', 'Form deleted successfully');
    }
}
