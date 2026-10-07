<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Create account_fields table
        |--------------------------------------------------------------------------
        */

        Schema::connection('tenant')->create('account_fields', function (Blueprint $t) {
            $t->id();

            $t->string('key')->unique();
            $t->string('label');
            $t->string('type')->default('text');
            $t->json('options')->nullable();
            $t->string('placeholder')->nullable();
            $t->string('help_text')->nullable();
            $t->string('default_value')->nullable();

            // Validation rules
            $t->unsignedSmallInteger('min_length')->nullable();
            $t->unsignedSmallInteger('max_length')->nullable();
            $t->string('validation_regex')->nullable();
            $t->string('validation_message')->nullable();

            // Behaviour
            $t->boolean('is_default')->default(false);
            $t->boolean('is_locked')->default(false);
            $t->boolean('is_required')->default(false);
            $t->boolean('is_unique')->default(false);
            $t->boolean('is_active')->default(true);
            $t->boolean('show_in_list')->default(false);
            $t->unsignedSmallInteger('sort_order')->default(0);

            $t->timestamps();
        });


        /*
        |--------------------------------------------------------------------------
        | 2. Copy all Lead fields into Account fields
        |--------------------------------------------------------------------------
        */

        $leadFields = DB::connection('tenant')
            ->table('lead_fields')
            ->orderBy('sort_order')
            ->get();

        foreach ($leadFields as $field) {

            DB::connection('tenant')
                ->table('account_fields')
                ->insert([
                    'key'                => $field->key,
                    'label'              => $field->label,
                    'type'               => $field->type,
                    'options'            => $field->options,
                    'placeholder'        => $field->placeholder,
                    'help_text'          => $field->help_text,
                    'default_value'      => $field->default_value,

                    'min_length'         => $field->min_length,
                    'max_length'         => $field->max_length,
                    'validation_regex'   => $field->validation_regex,
                    'validation_message' => $field->validation_message,

                    'is_default'         => true,
                    'is_locked'          => $field->is_locked,
                    'is_required'        => $field->is_required,
                    'is_unique'          => $field->is_unique,
                    'is_active'          => $field->is_active,
                    'show_in_list'       => $field->show_in_list,
                    'sort_order'         => $field->sort_order,

                    'created_at'         => now(),
                    'updated_at'         => now(),
                ]);
        }


        $lastSortOrder = DB::connection('tenant')
            ->table('account_fields')
            ->max('sort_order') ?? 0;


        $accountFields = [

            [
                'key'         => 'account_name',
                'label'       => 'Account Name',
                'type'        => 'text',
                'is_required' => true,
                'is_locked'   => true,
                'show_in_list'=> true,
                'max_length'  => 150,
            ],

            [
                'key'         => 'website',
                'label'       => 'Website',
                'type'        => 'url',
                'is_required' => false,
                'is_locked'   => false,
                'show_in_list'=> false,
                'max_length'  => 255,
            ],

            [
                'key'         => 'industry',
                'label'       => 'Industry',
                'type'        => 'text',
                'is_required' => false,
                'is_locked'   => false,
                'show_in_list'=> true,
                'max_length'  => 150,
            ],

            [
                'key'         => 'employees',
                'label'       => 'Employees',
                'type'        => 'number',
                'is_required' => false,
                'is_locked'   => false,
                'show_in_list'=> false,
                'max_length'  => null,
            ],

            [
                'key'         => 'annual_revenue',
                'label'       => 'Annual Revenue',
                'type'        => 'currency',
                'is_required' => false,
                'is_locked'   => false,
                'show_in_list'=> false,
                'max_length'  => null,
            ],

             [
                'key'         => 'password',
                'label'       => 'Password',
                'type'        => 'password',
                'is_required' => true,
                'is_locked'   => false,
                'show_in_list'=> false,
                'max_length'  => null,
            ],
        ];


        foreach ($accountFields as $index => $field) {

            DB::connection('tenant')
                ->table('account_fields')
                ->insert([
                    'key'          => $field['key'],
                    'label'        => $field['label'],
                    'type'         => $field['type'],

                    'options'      => null,
                    'placeholder'  => null,
                    'help_text'    => null,
                    'default_value'=> null,

                    'min_length'   => null,
                    'max_length'   => $field['max_length'],

                    'validation_regex'   => null,
                    'validation_message' => null,

                    'is_default'   => true,
                    'is_locked'    => $field['is_locked'],
                    'is_required'  => $field['is_required'],
                    'is_unique'    => false,
                    'is_active'    => true,
                    'show_in_list' => $field['show_in_list'],

                    'sort_order'   => $lastSortOrder + $index + 1,

                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
        }
    }


    public function down(): void
    {
        Schema::connection('tenant')->dropIfExists('account_fields');
    }
};