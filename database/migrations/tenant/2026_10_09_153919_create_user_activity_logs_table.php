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
        Schema::connection('tenant')->create('user_activity_logs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->index();

            $table->timestamp('session_started_at')->nullable();
            $table->timestamp('last_activity_at')->nullable();

            $table->timestamp('idle_started_at')->nullable();
            $table->unsignedInteger('idle_duration_seconds')->default(0);

            $table->timestamp('session_ended_at')->nullable();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('tenant')->dropIfExists('user_activity_logs');
    }
};
