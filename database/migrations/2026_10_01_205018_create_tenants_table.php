<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('domain')->unique();
            $t->string('db_host')->default('127.0.0.1');
            $t->unsignedSmallInteger('db_port')->default(3306);
            $t->string('db_name')->unique();
            $t->string('db_username');
            $t->text('db_password');
            $t->string('region')->nullable();
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};