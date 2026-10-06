<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadField extends Model
{
    public const TYPES = [
        'text', 'textarea', 'number', 'currency', 'email', 'phone',
        'url', 'date', 'datetime', 'select', 'multiselect', 'checkbox',
    ];

    public const MAX_CUSTOM_FIELDS = 20;

    protected $connection = 'tenant';
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'options'      => 'array',
            'is_default'   => 'boolean',
            'is_locked'    => 'boolean',
            'is_required'  => 'boolean',
            'is_unique'    => 'boolean',
            'is_active'    => 'boolean',
            'show_in_list' => 'boolean',
        ];
    }
}