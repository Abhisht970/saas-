<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class TenantsMigrate extends Command
{
    protected $signature = 'tenants:migrate';
    protected $description = 'Run tenant migrations for all active tenants';

    public function handle()
    {
        Tenant::on('mysql')->where('is_active', true)->each(function ($tenant) {
            $this->info("Migrating {$tenant->name} ({$tenant->db_name})");

            try {
                $tenant->connect();

                Artisan::call('migrate', [
                    '--database' => 'tenant',
                    '--path' => 'database/migrations/tenant',
                    '--force' => true,
                ]);

                $this->line(Artisan::output());
            } catch (\Throwable $e) {
                $this->error("FAILED {$tenant->name}: " . $e->getMessage());
            }
        });
    }
}