<?php

namespace App\Enums;

enum CreditPeriodTypeEnum: int
{
    case MENSAL = 1;

    public static function getAll(){
        return [
            self::MENSAL->value => 'Mensal',
        ];
    }

    public static function getDataToInsert(): array
    {
        return [
            [
                'id' => self::MENSAL->value,
                'name' => 'Mensal',
                'description' => 'Vigência mensal.',
            ]
        ];
    }
}