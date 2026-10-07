<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\SuperAdmin;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SuperAdmin::updateOrCreate(
            [
                'email' => "superadmin@gmail.com"
            ],
            [
                'name' => 'admin',
                'password' => Hash::make('Admin@123'),
                'role' => 'admin'
            ]
        );
    }
}
