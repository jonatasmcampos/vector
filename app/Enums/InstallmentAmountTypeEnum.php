<?php

namespace App\Enums;

enum InstallmentAmountTypeEnum: int
{
    case FIXED = 1;
    case PERCENTAGE = 2;

    public static function getDataToInsert(): array{
        return [
            [
                'id' => self::FIXED->value,
                'name' => 'Fixo',
                'description' => null,
            ],
            [
                'id' => self::PERCENTAGE->value,
                'name' => 'Porcentagem',
                'description' => null,
            ]
        ];
    }
}