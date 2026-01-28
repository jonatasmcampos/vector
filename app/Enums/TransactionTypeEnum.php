<?php

namespace App\Enums;

enum TransactionTypeEnum: int
{
    case ACQUISITION = 1;
    case PAYMENT = 2;
    case CANCELLATION = 3;

    public static function getDataToInsert(): array{
        return [
            [
                'id' => self::ACQUISITION->value,
                'name' => 'Aquisição',
                'description' => null,
            ],
            [
                'id' => self::PAYMENT->value,
                'name' => 'Pagamento',
                'description' => null,
            ],
            [
                'id' => self::CANCELLATION->value,
                'name' => 'Cancelamento',
                'description' => null,
            ]
        ];
    }
}