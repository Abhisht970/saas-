<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class TenantUser extends Authenticatable {
    protected $connection = 'tenant';
    protected $table = 'users';
    protected $guarded = [];
    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array {
        return ['password' => 'hashed'];
    }

}
