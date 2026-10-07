<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('tenant')->create('dynamic_records', function (Blueprint $table) {

            $table->id();


            /*
            |--------------------------------------------------------------------------
            | Dynamic Object
            |--------------------------------------------------------------------------
            |
            | Identifies which object this record belongs to.
            |
            | Example:
            |
            | 1 = Task
            | 2 = Vendor
            | 3 = Project
            |
            */

            $table->foreignId('object_id')
                ->constrained('dynamic_objects')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Record Data
            |--------------------------------------------------------------------------
            |
            | All dynamic field values will be stored here.
            |
            | Example Task:
            |
            | {
            |     "task_name": "Call Customer",
            |     "priority": "High",
            |     "due_date": "2026-10-10",
            |     "completed": false
            | }
            |
            */

            $table->json('data');


            /*
            |--------------------------------------------------------------------------
            | Record Name
            |--------------------------------------------------------------------------
            |
            | Useful for listing, searching, relationships etc.
            |
            | Example:
            |
            | Call Customer
            | ABC Technologies
            | Website Development
            |
            */

            $table->string('record_name', 255)
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Ownership
            |--------------------------------------------------------------------------
            */

            $table->foreignId('owner_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Created By
            |--------------------------------------------------------------------------
            */

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Updated By
            |--------------------------------------------------------------------------
            */

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Timestamps
            |--------------------------------------------------------------------------
            */

            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Soft Delete
            |--------------------------------------------------------------------------
            */

            $table->softDeletes();


            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('object_id');

            $table->index('record_name');

            $table->index('owner_id');

            $table->index([
                'object_id',
                'created_at'
            ]);

        });
    }


    public function down(): void
    {
        Schema::connection('tenant')
            ->dropIfExists('dynamic_records');
    }
};