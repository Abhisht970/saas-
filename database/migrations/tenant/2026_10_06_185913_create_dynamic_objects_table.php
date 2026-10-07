<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('tenant')->create('dynamic_objects', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Object Information
            |--------------------------------------------------------------------------
            */

            // Example: Task, Vendor, Project
            $table->string('name', 100);

            // Example: task, vendor, project
            // Internal unique identifier / API name
            $table->string('key', 100)->unique();

            // Example: Tasks, Vendors, Projects
            $table->string('plural_label', 100)->nullable();

            // Optional description
            $table->text('description')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Object Settings
            |--------------------------------------------------------------------------
            */

            // Object enabled / disabled
            $table->boolean('is_active')
                ->default(true);

            // System object or user-created object
            $table->boolean('is_system')
                ->default(false);

            // Allow records to be created
            $table->boolean('allow_create')
                ->default(true);

            // Allow records to be edited
            $table->boolean('allow_edit')
                ->default(true);

            // Allow records to be deleted
            $table->boolean('allow_delete')
                ->default(true);


            /*
            |--------------------------------------------------------------------------
            | Display Settings
            |--------------------------------------------------------------------------
            */

            // Optional icon name
            $table->string('icon', 100)
                ->nullable();

            // Sidebar / menu ordering
            $table->unsignedInteger('sort_order')
                ->default(0);


            /*
            |--------------------------------------------------------------------------
            | System Information
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
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('name');
            $table->index('is_active');
            $table->index('sort_order');
        });
    }


    public function down(): void
    {
        Schema::connection('tenant')
            ->dropIfExists('dynamic_objects');
    }
};