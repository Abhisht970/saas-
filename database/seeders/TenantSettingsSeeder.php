<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\TenantSetting::updateOrCreate(
            ['key' => 'inactivity_timeout_seconds'],
            [
                'group' => 'activity',
                'label' => 'User Inactivity Timeout',
                'description' => 'Seconds without user activity before marking the user idle.',
                'value' => '30',
                'type' => 'integer',
                'options' => json_encode([30, 60, 300, 600, 1800, 3000]),
                'validation_rules' => json_encode(['required', 'integer', 'min:30']),
                'default_value' => '30',
                'is_editable' => true,
                'is_active' => true,
            ]
        );
    }
}
