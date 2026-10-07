<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('tenant')->create('dynamic_fields', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Object
            |--------------------------------------------------------------------------
            */

            $table->foreignId('object_id')
                ->constrained('dynamic_objects')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Field Information
            |--------------------------------------------------------------------------
            |
            | Example:
            |
            | label = Task Name
            | key   = task_name
            | type  = text
            |
            */

            $table->string('label', 150);

            $table->string('key', 150);

            $table->string('type', 50)
                ->default('text');


            /*
            |--------------------------------------------------------------------------
            | Options
            |--------------------------------------------------------------------------
            |
            | Used for:
            | select
            | radio
            | multi-select
            |
            | Example:
            |
            | ["High", "Medium", "Low"]
            |
            */

            $table->json('options')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Display
            |--------------------------------------------------------------------------
            */

            $table->string('placeholder', 255)
                ->nullable();

            $table->text('help_text')
                ->nullable();

            $table->text('default_value')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Validation
            |--------------------------------------------------------------------------
            */

            $table->unsignedInteger('min_length')
                ->nullable();

            $table->unsignedInteger('max_length')
                ->nullable();

            $table->string('validation_regex', 500)
                ->nullable();

            $table->string('validation_message', 255)
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Field Behaviour
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_required')
                ->default(false);

            $table->boolean('is_unique')
                ->default(false);

            $table->boolean('is_active')
                ->default(true);

            $table->boolean('is_locked')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | List View
            |--------------------------------------------------------------------------
            |
            | If true, field automatically appears in dynamic object's
            | index/list page.
            |
            */

            $table->boolean('show_in_list')
                ->default(false);


            /*
            |--------------------------------------------------------------------------
            | Search
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_searchable')
                ->default(false);


            /*
            |--------------------------------------------------------------------------
            | Sorting
            |--------------------------------------------------------------------------
            */

            $table->unsignedInteger('sort_order')
                ->default(0);


            /*
            |--------------------------------------------------------------------------
            | System
            |--------------------------------------------------------------------------
            */

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->softDeletes();


            /*
            |--------------------------------------------------------------------------
            | Constraints / Indexes
            |--------------------------------------------------------------------------
            |
            | Same object cannot contain same field key twice.
            |
            | Task:
            | task_name ✓
            | task_name ✗ duplicate
            |
            | Vendor:
            | task_name ✓ because different object
            |
            */

            $table->unique(
                ['object_id', 'key'],
                'dynamic_fields_object_key_unique'
            );

            $table->index([
                'object_id',
                'is_active',
                'sort_order'
            ]);

            $table->index([
                'object_id',
                'show_in_list'
            ]);
        });
    }


    public function down(): void
    {
        Schema::connection('tenant')
            ->dropIfExists('dynamic_fields');
    }
};