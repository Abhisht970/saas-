<?php

namespace App\Http\Controllers;

use App\Models\DynamicObject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DynamicObjectController extends Controller
{
    /**
     * List all dynamic objects.
     */
    public function index()
    {
        $objects = DynamicObject::query()
            ->withCount(['fields', 'records'])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(20);

        return view('dynamic-objects.index', compact('objects'));
    }

    /**
     * Show create object form.
     */
    public function create()
    {
        return view('dynamic-objects.create');
    }

    /**
     * Save new dynamic object.
     */
    public function store(Request $request)
    {
        
        // Automatically create key if user doesn't enter one.
        $request->merge([
            'key' => Str::snake(
                $request->filled('key')
                    ? $request->key
                    : $request->name
            ),
        ]);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'key' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-z][a-z0-9_]*$/',
                Rule::unique('tenant.dynamic_objects', 'key'),
            ],

            'plural_label' => [
                'nullable',
                'string',
                'max:100',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'icon' => [
                'nullable',
                'string',
                'max:100',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ], [
            'key.regex' => 'Object key may contain only lowercase letters, numbers and underscores, and must start with a letter.',
            'key.unique' => 'This object key already exists.',
        ]);

        $object = DynamicObject::create([
            'name' => $validated['name'],

            'key' => $validated['key'],

            'plural_label' => $validated['plural_label']
                ?: Str::plural($validated['name']),

            'description' => $validated['description'] ?? null,

            'icon' => $validated['icon'] ?? null,

            'sort_order' => $validated['sort_order'] ?? 0,

            'is_active' => true,

            'is_system' => false,

            'allow_create' => $request->boolean('allow_create'),

            'allow_edit' => $request->boolean('allow_edit'),

            'allow_delete' => $request->boolean('allow_delete'),

            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('dynamic-objects.show', $object)
            ->with('success', 'Object created successfully. Now you can add fields.');
    }

    /**
     * Object details.
     */
    public function show(DynamicObject $dynamicObject)
    {
        $dynamicObject->load([
            'fields' => function ($query) {
                $query->orderBy('sort_order');
            }
        ]);

        return view(
            'dynamic-objects.show',
            compact('dynamicObject')
        );
    }
}