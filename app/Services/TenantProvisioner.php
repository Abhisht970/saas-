<?php

namespace App\Services;

use App\Models\Tenant;
use App\Models\TenantUser;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TenantProvisioner
{
    public function create(string $name, string $domain, string $adminEmail, string $adminPassword): Tenant
    {
        $dbName = 'crm_' . Str::slug($name, '_') . '_' . Str::lower(Str::random(4));
        $tenant = null;

        DB::connection('mysql')->statement(
            "CREATE DATABASE `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
        );

        try {
            $tenant = Tenant::create([
                'name'        => $name,
                'domain'      => $domain,
                'db_host'     => env('DB_HOST', '127.0.0.1'),
                'db_port'     => env('DB_PORT', 3306),
                'db_name'     => $dbName,
                'db_username' => env('DB_USERNAME') ??  config('database.connections.mysql.username') ?? 'root',
                'db_password' => env('DB_PASSWORD') ?? config('database.connections.mysql.password') ?? '',
            ]);

            $tenant->connect();

            Artisan::call('migrate', [
                '--database' => 'tenant',
                '--path'     => 'database/migrations/tenant',
                '--force'    => true,
            ]);

            TenantUser::create([
                'name'     => 'Admin',
                'email'    => $adminEmail,
                'password' => $adminPassword,
            ]);

            return $tenant;
        } catch (\Throwable $e) {
            
            $tenant?->delete();
            DB::connection('mysql')->statement("DROP DATABASE IF EXISTS `$dbName`");
            throw $e;
        }
    }
}