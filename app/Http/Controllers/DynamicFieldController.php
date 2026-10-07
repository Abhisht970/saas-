<?php

namespace App\Http\Controllers;

use App\Models\DynamicField;
use App\Models\DynamicObject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DynamicFieldController extends Controller
{
    /**
     * Show add field form.
     */
    public function create(DynamicObject $dynamicObject)
    {
        return view('dynamic-fields.create', compact('dynamicObject'));
    }

    /**
     * Store new field.
     */
    public function store(Request $request, DynamicObject $dynamicObject)
    {
        $request->merge([
            'key' => Str::snake(
                $request->filled('key')
                    ? $request->key
                    : $request->label
            ),
        ]);

        $validated = $request->validate([
            'label' => [
                'required',
                'string',
                'max:150',
            ],

            'key' => [
                'required',
                'string',
                'max:150',
                'regex:/^[a-z][a-z0-9_]*$/',

                Rule::unique('tenant.dynamic_fields', 'key')
                    ->where(function ($query) use ($dynamicObject) {
                        return $query->where(
                            'object_id',
                            $dynamicObject->id
                        );
                    }),
            ],

            'type' => [
                'required',
                Rule::in([
                    'text',
                    'textarea',
                    'email',
                    'phone',
                    'number',
                    'currency',
                    'url',
                    'password',
                    'date',
                    'datetime',
                    'select',
                    'radio',
                    'checkbox',
                ]),
            ],

            'placeholder' => [
                'nullable',
                'string',
                'max:255',
            ],

            'help_text' => [
                'nullable',
                'string',
            ],

            'default_value' => [
                'nullable',
                'string',
            ],

            'min_length' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'max_length' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'validation_regex' => [
                'nullable',
                'string',
                'max:500',
            ],

            'validation_message' => [
                'nullable',
                'string',
                'max:255',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'options' => [
                'nullable',
                'string',
            ],
        ], [
            'key.regex' =>
                'Field key may contain only lowercase letters, numbers and underscores.',
        ]);

        $options = null;

        if (in_array($validated['type'], [
            'select',
            'radio',
        ])) {

            $options = collect(
                preg_split(
                    '/\r\n|\r|\n|,/',
                    $validated['options'] ?? ''
                )
            )
                ->map(fn ($item) => trim($item))
                ->filter()
                ->unique()
                ->values()
                ->all();
        }

        DynamicField::create([
            'object_id' => $dynamicObject->id,

            'label' => $validated['label'],

            'key' => $validated['key'],

            'type' => $validated['type'],

            'options' => $options,

            'placeholder' =>
                $validated['placeholder'] ?? null,

            'help_text' =>
                $validated['help_text'] ?? null,

            'default_value' =>
                $validated['default_value'] ?? null,

            'min_length' =>
                $validated['min_length'] ?? null,

            'max_length' =>
                $validated['max_length'] ?? null,

            'validation_regex' =>
                $validated['validation_regex'] ?? null,

            'validation_message' =>
                $validated['validation_message'] ?? null,

            'is_required' =>
                $request->boolean('is_required'),

            'is_unique' =>
                $request->boolean('is_unique'),

            'is_active' =>
                $request->boolean('is_active'),

            'is_locked' => false,

            'show_in_list' =>
                $request->boolean('show_in_list'),

            'is_searchable' =>
                $request->boolean('is_searchable'),

            'sort_order' =>
                $validated['sort_order'] ?? 0,

            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route(
                'dynamic-objects.show',
                $dynamicObject
            )
            ->with(
                'success',
                'Field created successfully.'
            );
    }
}