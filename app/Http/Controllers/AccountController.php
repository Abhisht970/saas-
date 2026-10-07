<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountField;
use Illuminate\Http\Request;
class AccountController extends Controller
{
    /**
     * Display Account listing.
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Dynamic List Fields
        |--------------------------------------------------------------------------
        |
        | Sirf wahi active fields table mein show honge
        | jinke show_in_list = 1 hai.
        |
        */

        $fields = AccountField::query()
            ->where('is_active', true)
            ->where('show_in_list', true)
            ->orderBy('sort_order')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Accounts
        |--------------------------------------------------------------------------
        */

        $accounts = Account::query()
            ->latest('id')
            ->paginate(20);


        return view(
            'accounts.index',
            compact('accounts', 'fields')
        );
    }

    public function create()
    {
        $fields = AccountField::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('accounts.create', compact('fields'));
    }

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Get Active Account Fields
        |--------------------------------------------------------------------------
        */

        $fields = AccountField::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Build Dynamic Validation Rules
        |--------------------------------------------------------------------------
        */

        $rules = [];

        $messages = [];

        foreach ($fields as $field) {

            $fieldRules = [];

            /*
            | Required / Nullable
            */
            if ($field->is_required) {
                $fieldRules[] = 'required';
            } else {
                $fieldRules[] = 'nullable';
            }


            /*
            | Validation according to field type
            */
            switch ($field->type) {

                case 'email':
                    $fieldRules[] = 'email';
                    break;

                case 'url':
                    $fieldRules[] = 'url';
                    break;

                case 'number':
                case 'currency':
                    $fieldRules[] = 'numeric';
                    break;

                case 'date':
                    $fieldRules[] = 'date';
                    break;

                case 'checkbox':
                    $fieldRules[] = 'boolean';
                    break;

                default:
                    $fieldRules[] = 'string';
                    break;
            }


            /*
            | Minimum Length
            */
            if (
                $field->min_length !== null &&
                in_array($field->type, [
                    'text',
                    'textarea',
                    'email',
                    'url',
                    'password'
                ])
            ) {
                $fieldRules[] = 'min:' . $field->min_length;
            }


            /*
            | Maximum Length
            */
            if (
                $field->max_length !== null &&
                in_array($field->type, [
                    'text',
                    'textarea',
                    'email',
                    'url',
                    'password'
                ])
            ) {
                $fieldRules[] = 'max:' . $field->max_length;
            }


            /*
            | Custom Regex
            */
            if ($field->validation_regex) {
                $fieldRules[] = 'regex:' . $field->validation_regex;
            }


            $rules[$field->key] = $fieldRules;


            /*
            | Custom Validation Message
            */
            if ($field->validation_message) {

                $messages[$field->key . '.regex'] =
                    $field->validation_message;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Validate
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate(
            $rules,
            $messages
        );


        /*
        |--------------------------------------------------------------------------
        | Separate Default & Custom Fields
        |--------------------------------------------------------------------------
        */

        $accountData = [];

        $customData = [];


        foreach ($fields as $field) {

            /*
            | Checkbox needs special handling because unchecked
            | checkbox is not submitted by HTML.
            */

            if ($field->type === 'checkbox') {

                $value = $request->boolean($field->key);

            } else {

                $value = $request->input($field->key);

            }


            /*
            |--------------------------------------------------------------------------
            | Default Field
            |--------------------------------------------------------------------------
            */

            if ($field->is_default) {

                $accountData[$field->key] = $value;

            }

            /*
            |--------------------------------------------------------------------------
            | Custom Field
            |--------------------------------------------------------------------------
            */ else {

                $customData[$field->key] = $value;

            }
        }


        /*
        |--------------------------------------------------------------------------
        | Custom Data
        |--------------------------------------------------------------------------
        */

        $accountData['custom_data'] = $customData;


        /*
        |--------------------------------------------------------------------------
        | System Fields
        |--------------------------------------------------------------------------
        */

        $accountData['owner_id'] = auth()->id();

        $accountData['created_by'] = auth()->id();


        /*
        |--------------------------------------------------------------------------
        | Create Account
        |--------------------------------------------------------------------------
        */

        Account::create($accountData);


        return redirect()
            ->route('accounts.index')
            ->with(
                'success',
                'Account created successfully.'
            );
    }
}