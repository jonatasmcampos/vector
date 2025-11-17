<?php

namespace App\Enums;

enum PurchaseOrderTypeEnum: int
{
    case STANDARD = 1;
    case DIRECT = 2;
    case EMERGENCY = 3;

    public static function getDataToInsert(): array{
        return [
            [
                'id' => self::STANDARD->value,
                'name' => 'Padrão',
                'description' => 'Ordem de compra padrão',
            ],
            [
                'id' => self::DIRECT->value,
                'name' => 'Direta',
                'description' => 'Ordem de compra direta',
            ],
            [
                'id' => self::EMERGENCY->value,
                'name' => 'Emergêncial',
                'description' => 'Ordem de compra emergêncial',
            ],
        ];
    }
}