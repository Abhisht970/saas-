<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DynamicField extends Model
{
    use SoftDeletes;

    protected $connection = 'tenant';

    protected $table = 'dynamic_fields';

    protected $fillable = [
        'object_id',
        'label',
        'key',
        'type',
        'options',
        'placeholder',
        'help_text',
        'default_value',
        'min_length',
        'max_length',
        'validation_regex',
        'validation_message',
        'is_required',
        'is_unique',
        'is_active',
        'is_locked',
        'show_in_list',
        'is_searchable',
        'sort_order',
        'created_by',
    ];

    protected $casts = [
        'options'        => 'array',

        'is_required'    => 'boolean',
        'is_unique'      => 'boolean',
        'is_active'      => 'boolean',
        'is_locked'      => 'boolean',
        'show_in_list'   => 'boolean',
        'is_searchable'  => 'boolean',

        'min_length'     => 'integer',
        'max_length'     => 'integer',
        'sort_order'     => 'integer',
    ];

    /**
     * Object this field belongs to.
     */
    public function object(): BelongsTo
    {
        return $this->belongsTo(
            DynamicObject::class,
            'object_id'
        );
    }
}