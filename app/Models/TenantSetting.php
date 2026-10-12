<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantSetting extends Model
{
    protected $connection = 'tenant';

    protected $table = 'tenant_settings';

    protected $guarded = [];

    protected $casts = [
        'options' => 'array',
        'validation_rules' => 'array',
        'default_value' => 'string',
        'is_editable' => 'boolean',
        'is_active' => 'boolean',
    ];
}
