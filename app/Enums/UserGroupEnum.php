<?php

namespace App\Enums;

enum UserGroupEnum: int
{
    case PRESIDENTE = 1;

    public static function getDataToInsert(): array{
        return [
            [
                'id' => self::PRESIDENTE->value,
                'name' => 'Presidente',
                'description' => null,
            ]
        ];
    }
}