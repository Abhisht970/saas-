<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountField extends Model
{
    /**
     * Account fields are stored in the tenant database.
     */
    protected $connection = 'tenant';

    /**
     * Database table.
     */
    protected $table = 'account_fields';

    /**
     * Fields allowed for mass assignment.
     */
    protected $fillable = [
        'key',
        'label',
        'type',
        'options',
        'placeholder',
        'help_text',
        'default_value',

        'min_length',
        'max_length',
        'validation_regex',
        'validation_message',

        'is_default',
        'is_locked',
        'is_required',
        'is_unique',
        'is_active',
        'show_in_list',
        'sort_order',
    ];

    /**
     * Cast database values to correct PHP types.
     */
    protected $casts = [
        'options'       => 'array',

        'is_default'    => 'boolean',
        'is_locked'     => 'boolean',
        'is_required'   => 'boolean',
        'is_unique'     => 'boolean',
        'is_active'     => 'boolean',
        'show_in_list'  => 'boolean',

        'min_length'    => 'integer',
        'max_length'    => 'integer',
        'sort_order'    => 'integer',
    ];
}