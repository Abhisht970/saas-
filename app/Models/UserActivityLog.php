<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivityLog extends Model
{
    protected $connection = 'tenant';

    protected $table = 'user_activity_logs';

    protected $guarded = [];

    protected $casts = [
        'session_started_at' => 'datetime',
        'last_activity_at' => 'datetime',
        'idle_started_at' => 'datetime',
        'session_ended_at' => 'datetime',
    ];
}