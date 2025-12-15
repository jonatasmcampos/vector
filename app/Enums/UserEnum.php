<?php

namespace App\Enums;

use Illuminate\Support\Facades\Hash;

enum UserEnum: int
{
    case PRESIDENT = 1;

    public static function getDataToInsert(): array
    {
        return [
            [
                'id' => self::PRESIDENT->value,
                'name' => 'Peixoto Presidente',
                'login' => 'peixoto.adm',
                'email' => 'peixoto@presidente.com.br',
                'password' => Hash::make(12345),
                'cpf' => null,
                'phone' => null,
                'user_group_id' => UserGroupEnum::PRESIDENT,
                'user_master_cod' => 50,
                'active' => true,
            ]
        ];
    }
}