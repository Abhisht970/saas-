<?php
// app/Http/Middleware/IdentifyTenant.php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;

class IdentifyTenant
{
    public function handle(Request $request, Closure $next)
    {
        $tenant = Tenant::on('mysql')
            ->where('domain', $request->getHost())
            ->where('is_active', true)
            ->first();

        abort_if(!$tenant, 404, 'Tenant not found');

        $tenant->connect();

        return $next($request);
    }
}