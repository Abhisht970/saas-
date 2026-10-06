<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use SoftDeletes;

    // Purane dashboard ke liye abhi rakha hai, Step 8 me hat jayega
    public const STATUSES = ['Open - Not Contacted', 'Working - Contacted', 'Qualified', 'Unqualified'];

    protected $connection = 'tenant';
    protected $guarded = [];

    protected function casts(): array
    {
        return ['custom_data' => 'array'];
    }

    public function owner()
    {
        return $this->belongsTo(TenantUser::class, 'owner_id');
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }
}