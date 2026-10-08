<?php

namespace App\Http\Controllers;
use App\Models\{Lead, LeadField};

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Account;
class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leads = Lead::latest()->where('is_converted', false)->get();

        $fixedFields = [
            'first_name',
            'last_name',
            'company',
            'email',
            'phone',
            'status',
            'rating',
        ];

        $customFields = LeadField::where('is_active', true)
            ->where('show_in_list', true)
            ->orderBy('sort_order')
            ->get();
            
        return view('leads.index', compact(
            'leads',
            'customFields'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fields = LeadField::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('leads.create', compact('fields'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Validate Request
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'custom_data' => ['required', 'array'],

            // Fixed Lead Fields
            'custom_data.first_name' => ['nullable', 'string', 'max:80'],
            'custom_data.last_name' => ['nullable', 'string', 'max:80'],
            'custom_data.company' => ['nullable', 'string', 'max:150'],
            'custom_data.title' => ['nullable', 'string', 'max:150'],
            'custom_data.email' => ['nullable', 'email', 'max:150'],
            'custom_data.phone' => ['nullable', 'string', 'max:30'],
            'custom_data.lead_value' => ['nullable', 'string', 'max:255'],

            'custom_data.lead_source' => ['nullable', 'string', 'max:255'],
            'custom_data.status' => ['nullable', 'string', 'max:255'],
            'custom_data.rating' => ['nullable', 'string', 'max:255'],

            'custom_data.description' => ['nullable', 'string'],

            // Assignment
            'owner_id' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        $data = $validated['custom_data'];

        $fixedFields = [
            'first_name',
            'last_name',
            'company',
            'title',
            'email',
            'phone',
            'lead_value',
            'lead_source',
            'status',
            'rating',
            'description',
        ];

        $customData = collect($data)
            ->except($fixedFields)
            ->toArray();


        $fields = LeadField::where('is_active', true)
            ->whereNotIn('key', $fixedFields)
            ->orderBy('sort_order')
            ->get();


        foreach ($fields as $field) {

            $key = $field->key;

            $value = $request->input("custom_data.$key");


            if ($field->is_required) {

                if ($field->type === 'checkbox') {

                    if (!$request->has("custom_data.$key")) {

                        return back()
                            ->withErrors([
                                "custom_data.$key" =>
                                    "{$field->label} is required."
                            ])
                            ->withInput();
                    }

                } elseif ($value === null || $value === '') {

                    return back()
                        ->withErrors([
                            "custom_data.$key" =>
                                "{$field->label} is required."
                        ])
                        ->withInput();
                }
            }


            if ($field->type === 'checkbox') {

                $customData[$key] =
                    $request->boolean("custom_data.$key");

                continue;
            }


            if ($value === null || $value === '') {
                continue;
            }


            if (
                in_array($field->type, ['number', 'currency'], true)
                && !is_numeric($value)
            ) {

                return back()
                    ->withErrors([
                        "custom_data.$key" =>
                            "{$field->label} must be a number."
                    ])
                    ->withInput();
            }


            if ($field->type === 'email') {

                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {

                    return back()
                        ->withErrors([
                            "custom_data.$key" =>
                                "{$field->label} must be a valid email."
                        ])
                        ->withInput();
                }
            }


            if ($field->type === 'url') {

                if (!filter_var($value, FILTER_VALIDATE_URL)) {

                    return back()
                        ->withErrors([
                            "custom_data.$key" =>
                                "{$field->label} must be a valid URL."
                        ])
                        ->withInput();
                }
            }


            if ($field->type === 'select') {

                $options = $field->options ?? [];

                if (!in_array($value, $options, true)) {

                    return back()
                        ->withErrors([
                            "custom_data.$key" =>
                                "Invalid {$field->label} selected."
                        ])
                        ->withInput();
                }
            }


            if ($field->type === 'multiselect') {

                if (!is_array($value)) {

                    return back()
                        ->withErrors([
                            "custom_data.$key" =>
                                "{$field->label} must contain multiple values."
                        ])
                        ->withInput();
                }

                $options = $field->options ?? [];

                foreach ($value as $selectedValue) {

                    if (!in_array($selectedValue, $options, true)) {

                        return back()
                            ->withErrors([
                                "custom_data.$key" =>
                                    "Invalid value selected for {$field->label}."
                            ])
                            ->withInput();
                    }
                }
            }


            if (
                $field->max_length &&
                is_string($value) &&
                strlen($value) > $field->max_length
            ) {

                return back()
                    ->withErrors([
                        "custom_data.$key" =>
                            "{$field->label} cannot exceed {$field->max_length} characters."
                    ])
                    ->withInput();
            }


            $customData[$key] = $value;
        }


        Lead::create([

            // Fixed database columns
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'company' => $data['company'] ?? null,
            'title' => $data['title'] ?? null,
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'lead_value' => $data['lead_value'] ?? null,

            'lead_source' => $data['lead_source'] ?? null,
            'status' => $data['status'] ?? null,
            'rating' => $data['rating'] ?? null,

            'description' => $data['description'] ?? null,

            // System fields
            'owner_id' => $request->input('owner_id'),
            'created_by' => auth()->id(),

            // ONLY dynamic fields
            'custom_data' => $customData,
        ]);

        return redirect()
            ->route('leads.index')
            ->with('success', 'Lead created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function leadform()
    {
        $fields = Lead::getLeadFields();
        return response()->json($fields);
    }

    public function lead_form()
    {
        $fields = LeadField::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('lead-fields.index', compact('fields'));
    }

    public function lead_form_create()
    {
        return view('lead-fields.create');
    }

    public function lead_form_store(Request $request)
    {
        // 1. Validation
        $request->validate([
            'label' => ['required', 'string', 'max:255'],

            'key' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9_]+$/',
            ],

            'type' => ['required', 'in:' . implode(',', LeadField::TYPES)],

            'options' => ['nullable', 'string'],

            'placeholder' => ['nullable', 'string', 'max:255'],

            'max_length' => ['nullable', 'integer', 'min:1'],

            'sort_order' => ['nullable', 'integer', 'min:0'],

            'is_required' => ['nullable', 'boolean'],

            'is_active' => ['nullable', 'boolean'],

            'show_in_list' => ['nullable', 'boolean'],
        ]);
        
        if (LeadField::where('key', $request->key)->exists()) {

            return back()
                ->withErrors([
                    'key' => 'This field key already exists.'
                ])
                ->withInput();
        }


        // 3. Options prepare
        $options = null;

        if (in_array($request->type, ['select', 'multiselect'], true)) {

            $options = collect(
                preg_split(
                    '/\r\n|\r|\n/',
                    $request->options ?? ''
                )
            )
                ->map(fn($option) => trim($option))
                ->filter()
                ->values()
                ->all();
        }


        // 4. Create field
        LeadField::create([

            'key' => $request->key,

            'label' => $request->label,

            'type' => $request->type,

            'options' => $options,

            'placeholder' => $request->placeholder,

            'max_length' => $request->max_length,

            'is_default' => false,

            'is_required' => $request->boolean('is_required'),

            'is_active' => $request->boolean('is_active', true),

            'show_in_list' => $request->boolean('show_in_list'),

            'sort_order' => $request->input('sort_order', 0),
        ]);
        
        return redirect()
            ->route('leads.form')
            ->with('success', 'Lead field created successfully.');
    }

  public function convertToAccount(Lead $lead)
    {

        if ($lead->is_converted) {

            return back()->withErrors([
                'lead' => 'This lead has already been converted.'
            ]);
        }

        DB::connection('tenant')->transaction(function () use ($lead) {

            Account::create([
                'first_name'  => $lead->first_name,
                'last_name'   => $lead->last_name,
                'company'     => $lead->company,
                'title'       => $lead->title,
                'email'       => $lead->email,
                'phone'       => $lead->phone,
                'lead_value'  => $lead->lead_value,
                'lead_source' => $lead->lead_source,
                'status'      => $lead->status,
                'rating'      => $lead->rating,
                'description' => $lead->description,
                'account_name'  => $lead->company,
                'website'       => null,
                'industry'      => null,
                'employees'     => null,
                'annual_revenue'=> null,
                'password'      => null,
                'custom_data' => $lead->custom_data,
                'owner_id'   => $lead->owner_id,
                'created_by' => $lead->created_by,
            ]);

            $lead->update([
                'is_converted' => true,
            ]);
        });


        return redirect()
            ->route('leads.index')
            ->with('success', 'Lead converted to account successfully.');
    }
}
