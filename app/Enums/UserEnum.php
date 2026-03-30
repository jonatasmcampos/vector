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
                'name' => 'Fulano',
                'login' => 'fulano',
                'email' => 'fulano@presidente.com.br',
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