<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('tenant')->create('accounts', function (Blueprint $table) {

            $table->id();


            /*
            |--------------------------------------------------------------------------
            | Lead Based Default Fields
            |--------------------------------------------------------------------------
            |
            | These fields already exist in account_fields because lead_fields
            | were copied into account_fields.
            |
            */

            $table->string('first_name', 80)->nullable();

            $table->string('last_name', 80)->nullable();

            $table->string('company', 150)->nullable();

            $table->string('title', 150)->nullable();

            $table->string('email', 150)->nullable();

            $table->string('phone', 30)->nullable();

            $table->string('lead_value', 30)->nullable();

            $table->string('lead_source')->nullable();

            $table->string('status')->nullable();

            $table->string('rating')->nullable();

            $table->text('description')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Account Specific Default Fields
            |--------------------------------------------------------------------------
            */

            $table->string('account_name', 150)->nullable();

            $table->string('website', 255)->nullable();

            $table->string('industry', 150)->nullable();

            $table->unsignedInteger('employees')->nullable();

            $table->decimal(
                'annual_revenue',
                15,
                2
            )->nullable();

            $table->string('password', 255)->nullable();


            /*
            |--------------------------------------------------------------------------
            | Future Custom Fields
            |--------------------------------------------------------------------------
            |
            | Any NEW field created later from Account Field Manager will NOT
            | require a database column.
            |
            | It will be stored here:
            |
            | {
            |     "account_type": "Customer",
            |     "region": "North",
            |     "customer_code": "CUS-1001"
            | }
            |
            */

            $table->json('custom_data')->nullable();


            /*
            |--------------------------------------------------------------------------
            | System Fields
            |--------------------------------------------------------------------------
            */

            $table->foreignId('owner_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Timestamps
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

            $table->softDeletes();


            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('account_name');

            $table->index('email');

            $table->index('phone');

            $table->index('status');

            $table->index('industry');

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('tenant')
            ->dropIfExists('accounts');
    }
};