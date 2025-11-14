<?php

namespace App\Enums;

enum OriginEntityEnum: int
{
    case PURCHASE_ORDER = 1;
    case DIRECT_PURCHASE_ORDER = 2;
    case EMERGENCY_PURCHASE_ORDER = 3;

    public static function getDataToInsert(): array{
        return [
            [
                'id' => self::PURCHASE_ORDER->value,
                'name' => 'Ordem de compra',
                'description' => null,
            ],
            [
                'id' => self::DIRECT_PURCHASE_ORDER->value,
                'name' => 'Ordem de compra direta',
                'description' => null,
            ],
            [
                'id' => self::EMERGENCY_PURCHASE_ORDER->value,
                'name' => 'Ordem de compra emergêncial',
                'description' => null,
            ]
        ];
    }
}