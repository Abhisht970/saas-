<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tenant extends Model
{
    protected $connection = 'mysql'; // central
    protected $guarded = [];
    protected $casts = [
        'db_password' => 'encrypted',
        'is_active'   => 'boolean',
    ];

    public function connect(): void
    {
        config([
            'database.connections.tenant.host'     => $this->db_host,
            'database.connections.tenant.port'     => $this->db_port,
            'database.connections.tenant.database' => $this->db_name,
            'database.connections.tenant.username' => $this->db_username,
            'database.connections.tenant.password' => $this->db_password,
        ]);

        DB::purge('tenant');
        DB::reconnect('tenant');

        app()->instance('currentTenant', $this);
    }
}