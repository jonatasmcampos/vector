<?php

namespace App\Enums;

enum CreditUsageTypeEnum: int
{
    case SUPPLY = 1;

    public static function getAll(){
        return [
            self::SUPPLY->value => 'Insumo',
        ];
    }

    public static function getDataToInsert(): array
    {
        return [
            [
                'id' => self::SUPPLY->value,
                'name' => 'Insumo',
                'description' => 'Finalidade de adquirir bens ou matéria prima.',
            ]
        ];
    }
}