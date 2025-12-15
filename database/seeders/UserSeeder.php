<?php

namespace Database\Seeders;

use App\Enums\UserEnum;
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
        $users = UserEnum::getDataToInsert();
        $datas = $users;
        foreach ($datas as $data) {
            DB::table('users')->updateOrInsert(
                ['id' => $data['id']],   
                [
                    'name' => $data['name'],
                    'login' => $data['login'],
                    'email' => $data['email'],
                    'password' => $data['password'],
                    'cpf' => $data['cpf'],
                    'phone' => $data['phone'],
                    'user_group_id' => $data['user_group_id'],
                    'user_master_cod' => $data['user_master_cod'],
                    'active' => $data['active'],
                ]
            );
        }
    }
}
