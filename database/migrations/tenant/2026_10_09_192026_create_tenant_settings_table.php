<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('tenant')->create('tenant_settings', function (Blueprint $table) {
            $table->id();

            // Setting identification
            $table->string('group')->default('general')->index();
            $table->string('key')->unique();
            $table->string('label')->nullable();
            $table->text('description')->nullable();

            // Setting value
            $table->longText('value')->nullable();
            $table->string('type')->default('string');

            // Configuration rules
            $table->longText('options')->nullable();
            $table->longText('validation_rules')->nullable();
            $table->longText('default_value')->nullable();

            // Management
            $table->boolean('is_editable')->default(true);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();

            $table->index(['group', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::connection('tenant')->dropIfExists('tenant_settings');
    }
};
