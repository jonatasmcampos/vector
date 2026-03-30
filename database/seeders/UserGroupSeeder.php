<?php

namespace Database\Seeders;

use App\Enums\UserGroupEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grupos = UserGroupEnum::getDataToInsert();
        foreach ($grupos as $grupo) {
            DB::table('user_groups')->updateOrInsert(
                ['id' => $grupo['id']],
                [
                    'name' => $grupo['name'],
                    'description' => $grupo['description']
                ]
            );
        }
    }
}
