<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('tenant')->create('lead_fields', function (Blueprint $t) {
            $t->id();
            $t->string('key')->unique();                 // company, budget...
            $t->string('label');                         // form me dikhne wala naam
            $t->string('type')->default('text');         // text, textarea, number, currency, email, phone, url, date, datetime, select, multiselect, checkbox
            $t->json('options')->nullable();             // select / multiselect ki values
            $t->string('placeholder')->nullable();
            $t->string('help_text')->nullable();
            $t->string('default_value')->nullable();

            // Format rules (client define karega)
            $t->unsignedSmallInteger('min_length')->nullable();
            $t->unsignedSmallInteger('max_length')->nullable();
            $t->string('validation_regex')->nullable();      // custom pattern
            $t->string('validation_message')->nullable();    // pattern fail hone par message

            // Behaviour
            $t->boolean('is_default')->default(false);       // hamare 10 standard fields
            $t->boolean('is_locked')->default(false);        // required/hide nahi badal sakte (last_name)
            $t->boolean('is_required')->default(false);
            $t->boolean('is_unique')->default(false);
            $t->boolean('is_active')->default(true);
            $t->boolean('show_in_list')->default(false);
            $t->unsignedSmallInteger('sort_order')->default(0);
            $t->timestamps();
        });

        $now = now();

        // key, label, type, required, locked, in_list, options, max_length
        $fields = [
            ['first_name',  'First Name',  'text',     false, false, true,  null, 80],
            ['last_name',   'Last Name',   'text',     true,  true,  true,  null, 80],
            ['company',     'Company',     'text',     false, false, true,  null, 150],
            ['title',       'Title',       'text',     false, false, false, null, 100],
            ['email',       'Email',       'email',    false, false, true,  null, 150],
            ['phone',       'Phone',       'phone',    false, false, true,  null, 30],
            ['lead_value',       'Lead Lalue',       'text',    false, false, true,  null, 30],
            ['lead_source', 'Lead Source', 'select',   false, false, false,
                ['Web', 'Phone Inquiry', 'Partner Referral', 'Purchased List', 'Other'], null],
            ['status',      'Lead Status', 'select',   true,  false, true,
                ['Open - Not Contacted', 'Working - Contacted', 'Qualified', 'Unqualified'], null],
            ['rating',      'Rating',      'select',   false, false, false,
                ['Hot', 'Warm', 'Cold'], null],
            ['description', 'Description', 'textarea', false, false, false, null, 2000],
        ];

        foreach ($fields as $i => [$key, $label, $type, $required, $locked, $inList, $options, $max]) {
            DB::connection('tenant')->table('lead_fields')->insert([
                'key'          => $key,
                'label'        => $label,
                'type'         => $type,
                'options'      => $options ? json_encode($options) : null,
                'max_length'   => $max,
                'is_default'   => true,
                'is_locked'    => $locked,
                'is_required'  => $required,
                'is_active'    => true,
                'show_in_list' => $inList,
                'sort_order'   => $i + 1,
                'created_at'   => $now,
                'updated_at'   => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::connection('tenant')->dropIfExists('lead_fields');
    }
};