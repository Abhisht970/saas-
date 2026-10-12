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
        Schema::connection('tenant')
            ->table('user_activity_logs', function (Blueprint $table) {
                $table->uuid('session_token')->nullable()->index();
            });
    }

    public function down(): void
    {
        Schema::connection('tenant')
            ->table('user_activity_logs', function (Blueprint $table) {
                $table->dropColumn('session_token');
            });
    }
};
