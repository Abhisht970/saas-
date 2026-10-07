<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DynamicRecord extends Model
{
    use SoftDeletes;

    protected $connection = 'tenant';

    protected $table = 'dynamic_records';

    protected $fillable = [
        'object_id',
        'record_name',
        'data',
        'owner_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Object this record belongs to.
     */
    public function object(): BelongsTo
    {
        return $this->belongsTo(
            DynamicObject::class,
            'object_id'
        );
    }


    /**
     * Get value of any dynamic field.
     *
     * Example:
     *
     * $record->getFieldValue('priority');
     */
    public function getFieldValue(string $key, $default = null)
    {
        return data_get(
            $this->data ?? [],
            $key,
            $default
        );
    }
}