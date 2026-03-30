<?php

namespace Database\Seeders;

use App\Enums\ActionEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grupos = ActionEnum::getDataToInsert();
        foreach ($grupos as $grupo) {
            DB::table('actions')->updateOrInsert(
                ['id' => $grupo['id']],
                [
                    'name' => $grupo['name'],
                    'description' => $grupo['description']
                ]
            );
        }
    }
}
