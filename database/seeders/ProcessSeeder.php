<?php

namespace Database\Seeders;

use App\Enums\ProcessEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grupos = ProcessEnum::getDataToInsert();
        foreach ($grupos as $grupo) {
            DB::table('processes')->updateOrInsert(
                ['id' => $grupo['id']],
                [
                    'name' => $grupo['name'],
                    'description' => $grupo['description'],
                    'route' => $grupo['route'],
                    'order' => $grupo['order'],
                    'menu' => $grupo['menu'],
                    'icon' => $grupo['icon'],
                    'process' => $grupo['process'],
                ]
            );
        }
    }
}
