<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;

    protected $connection = 'tenant';

    protected $table = 'accounts';

    protected $fillable = [
        'first_name',
        'last_name',
        'company',
        'title',
        'email',
        'phone',
        'lead_value',
        'lead_source',
        'status',
        'rating',
        'description',

        'account_name',
        'website',
        'industry',
        'employees',
        'annual_revenue',
        'password',

        'custom_data',

        'owner_id',
        'created_by',
    ];

    protected $casts = [
        'custom_data' => 'array',
        'annual_revenue' => 'decimal:2',
        'employees' => 'integer',
    ];

    /**
     * Get dynamic field value.
     *
     * Default field:
     * accounts.account_name
     *
     * Custom field:
     * accounts.custom_data['customer_type']
     */
    public function getDynamicFieldValue($field)
    {
        if ($field->is_default) {
            return $this->{$field->key} ?? null;
        }

        return $this->custom_data[$field->key] ?? null;
    }
}