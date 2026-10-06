<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use App\Models\TenantUser;
use Illuminate\Console\Command;

class CreateTenantUser extends Command
{
    protected $signature = 'tenant:user {domain} {email} {password} {name=Admin}';
    protected $description = 'Create a user inside a tenant DB';

    public function handle()
    {
        $tenant = Tenant::on('mysql')->where('domain', $this->argument('domain'))->firstOrFail();
        $tenant->connect();

        TenantUser::create([
            'name'     => $this->argument('name'),
            'email'    => $this->argument('email'),
            'password' => $this->argument('password'),
        ]);

        $this->info("User created in {$tenant->db_name}");
    }
}