<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DynamicObject extends Model
{
    use SoftDeletes;

    protected $connection = 'tenant';

    protected $table = 'dynamic_objects';

    protected $fillable = [
        'name',
        'key',
        'plural_label',
        'description',
        'is_active',
        'is_system',
        'allow_create',
        'allow_edit',
        'allow_delete',
        'icon',
        'sort_order',
        'created_by',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'is_system'    => 'boolean',
        'allow_create' => 'boolean',
        'allow_edit'   => 'boolean',
        'allow_delete' => 'boolean',
        'sort_order'   => 'integer',
    ];

    /**
     * Fields belonging to this object.
     */
    public function fields(): HasMany
    {
        return $this->hasMany(
            DynamicField::class,
            'object_id'
        )->orderBy('sort_order');
    }

    /**
     * Active fields only.
     */
    public function activeFields(): HasMany
    {
        return $this->hasMany(
            DynamicField::class,
            'object_id'
        )
        ->where('is_active', true)
        ->orderBy('sort_order');
    }

    /**
     * Fields visible on list page.
     */
    public function listFields(): HasMany
    {
        return $this->hasMany(
            DynamicField::class,
            'object_id'
        )
        ->where('is_active', true)
        ->where('show_in_list', true)
        ->orderBy('sort_order');
    }

    /**
     * Records belonging to this object.
     */
    public function records(): HasMany
    {
        return $this->hasMany(
            DynamicRecord::class,
            'object_id'
        );
    }
}