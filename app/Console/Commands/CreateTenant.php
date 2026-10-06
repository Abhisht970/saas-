<?php
// app/Console/Commands/CreateTenant.php

namespace App\Console\Commands;

use App\Models\Tenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateTenant extends Command
{
    protected $signature = 'tenant:create {name} {domain}';
    protected $description = 'Create tenant DB, row and run tenant migrations';

    public function handle()
    {
        $name   = $this->argument('name');
        $domain = $this->argument('domain');
        $dbName = 'crm_' . Str::slug($name, '_') . '_' . Str::lower(Str::random(4));

        DB::connection('mysql')->statement(
            "CREATE DATABASE `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
        );

        // Local ke liye root credentials. Production me per-tenant DB user banana.
        $tenant = Tenant::create([
            'name'        => $name,
            'domain'      => $domain,
            'db_host'     => env('DB_HOST', '127.0.0.1'),
            'db_port'     => env('DB_PORT', 3306),
            'db_name'     => $dbName,
            'db_username' => env('DB_USERNAME'),
            'db_password' => env('DB_PASSWORD') ?? '',
        ]);

        $tenant->connect();

        Artisan::call('migrate', [
            '--database' => 'tenant',
            '--path'     => 'database/migrations/tenant',
            '--force'    => true,
        ]);

        $this->info("Tenant ready: {$domain} -> {$dbName}");
    }
}