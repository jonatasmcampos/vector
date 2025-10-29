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
        $user_groups = [
            [
                'id' => UserGroupEnum::PRESIDENTE->value,
                'name' => 'Presidente',
                'description' => null
            ]
        ];

        DB::table('user_groups')->insert($user_groups);
    }
}
