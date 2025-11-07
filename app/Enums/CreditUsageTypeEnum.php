<?php

namespace App\Enums;

enum CreditUsageTypeEnum: int
{
    case INSUMO = 1;

    public static function getAll(){
        return [
            self::INSUMO->value => 'Insumo',
        ];
    }

    public static function getDataToInsert(): array
    {
        return [
            [
                'id' => self::INSUMO->value,
                'name' => 'Insumo',
                'description' => 'Finalidade de adquirir bens ou matéria prima.',
            ]
        ];
    }
}