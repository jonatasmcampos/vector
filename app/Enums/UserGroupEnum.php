<?php

namespace App\Enums;

enum UserGroupEnum: int
{
    case PRESIDENT = 1;

    public static function getDataToInsert(): array{
        return [
            [
                'id' => self::PRESIDENT->value,
                'name' => 'Presidente',
                'description' => null,
            ]
        ];
    }
}