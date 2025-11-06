<?php

namespace Database\Seeders;

use App\Enums\UserGroupEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'José Miguel Peixoto',
                'login' => 'peixoto.adm',
                'email' => 'peixoto@mcde.com.br',
                'password' => Hash::make(12345),
                'cpf' => null,
                'phone' => null,
                'user_group_id' => UserGroupEnum::PRESIDENTE,
                'user_master_cod' => 50,
                'selected_contract_id' => 2,
                'active' => true,
            ]
        ];

        DB::table('users')->insert($users);
    }
}
