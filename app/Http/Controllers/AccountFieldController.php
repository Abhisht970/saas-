<?php

namespace App\Http\Controllers;

use App\Models\AccountField;
use Illuminate\Http\Request;

class AccountFieldController extends Controller
{
    /**
     * Display all account fields.
     */
    public function index()
    {
        $fields = AccountField::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('account-fields.index', compact('fields'));
    }

       
    public function create()
    {
        return view('account-fields.create');
    }


    /**
     * Store new account field.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z][a-z0-9_]*$/',
                Rule::unique('account_fields', 'key')
                    ->connection('tenant'),
            ],

            'label' => [
                'required',
                'string',
                'max:255',
            ],

            'type' => [
                'required',
                'string',
                Rule::in([
                    'text',
                    'textarea',
                    'email',
                    'number',
                    'url',
                    'password',
                    'date',
                    'datetime',
                    'select',
                    'radio',
                    'checkbox',
                    'currency',
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
                'max:255',
            ],

            'default_value' => [
                'nullable',
                'string',
                'max:255',
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
                'max:255',
            ],

            'validation_message' => [
                'nullable',
                'string',
                'max:255',
            ],

            'options' => [
                'nullable',
                'string',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Convert options textarea into JSON array
        |--------------------------------------------------------------------------
        */

        $options = null;

        if ($request->filled('options')) {
            $options = collect(
                preg_split('/\r\n|\r|\n/', $request->options)
            )
                ->map(fn ($option) => trim($option))
                ->filter()
                ->values()
                ->toArray();
        }


        /*
        |--------------------------------------------------------------------------
        | Find next sort order
        |--------------------------------------------------------------------------
        */

        $nextSortOrder = AccountField::max('sort_order') + 1;


        /*
        |--------------------------------------------------------------------------
        | Create Account Field
        |--------------------------------------------------------------------------
        */

        AccountField::create([
            'key' => $validated['key'],

            'label' => $validated['label'],

            'type' => $validated['type'],

            'options' => $options,

            'placeholder' => $validated['placeholder'] ?? null,

            'help_text' => $validated['help_text'] ?? null,

            'default_value' => $validated['default_value'] ?? null,

            'min_length' => $validated['min_length'] ?? null,

            'max_length' => $validated['max_length'] ?? null,

            'validation_regex' =>
                $validated['validation_regex'] ?? null,

            'validation_message' =>
                $validated['validation_message'] ?? null,

            'is_default' => false,

            'is_locked' => false,

            'is_required' =>
                $request->boolean('is_required'),

            'is_unique' =>
                $request->boolean('is_unique'),

            'is_active' =>
                $request->boolean('is_active'),

            'show_in_list' =>
                $request->boolean('show_in_list'),

            'sort_order' => $nextSortOrder,
        ]);


        return redirect()
            ->route('account-fields.index')
            ->with(
                'success',
                'Account field created successfully.'
            );
    }
}