<?php

namespace Database\Seeders;

use App\Enums\SettingsEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (SettingsEnum::getDataToInsert() as $setting) {
            DB::table('settings')->insertOrIgnore($setting);
        }
    }
}
