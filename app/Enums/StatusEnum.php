<?php

namespace App\Enums;

enum StatusEnum: int
{
    case PENDING = 1;
    case CONFIRMED = 2;
    case PAID = 3;
    case CANCELLED = 4;

    public static function getDataToInsert(): array{
        return [
            [
                'id' => self::PENDING->value,
                'name' => 'Pendente',
                'description' => null,
            ],
            [
                'id' => self::CONFIRMED->value,
                'name' => 'Confirmado',
                'description' => null,
            ],
            [
                'id' => self::PAID->value,
                'name' => 'Pago',
                'description' => null,
            ],
            [
                'id' => self::CANCELLED->value,
                'name' => 'Cancelado',
                'description' => null,
            ]
        ];
    }
}