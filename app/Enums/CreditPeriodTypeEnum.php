<?php

namespace App\Enums;

enum CreditPeriodTypeEnum: int
{
    case MONTHLY = 1;

    public static function getAll(){
        return [
            self::MONTHLY->value => 'Mensal',
        ];
    }

    public static function getDataToInsert(): array
    {
        return [
            [
                'id' => self::MONTHLY->value,
                'name' => 'Mensal',
                'description' => 'Vigência mensal.',
            ]
        ];
    }
}