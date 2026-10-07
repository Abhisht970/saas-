<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class TenantsRollback extends Command
{
    protected $signature = 'tenants:rollback {--step=1 : Number of migration batches/steps to rollback}';

    protected $description = 'Rollback tenant migrations for all active tenants';

    public function handle()
    {
        Tenant::on('mysql')
            ->where('is_active', true)
            ->each(function ($tenant) {

                $this->info(
                    "Rolling back {$tenant->name} ({$tenant->db_name})"
                );

                try {
                    /*
                    |--------------------------------------------------------------------------
                    | Connect current tenant database
                    |--------------------------------------------------------------------------
                    */

                    $tenant->connect();


                    /*
                    |--------------------------------------------------------------------------
                    | Run rollback
                    |--------------------------------------------------------------------------
                    */

                    Artisan::call('migrate:rollback', [
                        '--database' => 'tenant',
                        '--path'     => 'database/migrations/tenant',
                        '--step'     => (int) $this->option('step'),
                        '--force'    => true,
                    ]);


                    /*
                    |--------------------------------------------------------------------------
                    | Show Laravel migration output
                    |--------------------------------------------------------------------------
                    */

                    $this->line(Artisan::output());

                    $this->info(
                        "Rollback completed for {$tenant->name}"
                    );

                } catch (\Throwable $e) {

                    $this->error(
                        "FAILED {$tenant->name}: " . $e->getMessage()
                    );
                }
            });

        return Command::SUCCESS;
    }
}