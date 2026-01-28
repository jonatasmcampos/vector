<?php

namespace App\Enums;

enum PaymentMethodEnum: int
{
    case IN_FULL = 1;
    case ON_INSTALLMENTS = 2;

    public static function getDataToInsert(): array{
        return [
            [
                'id' => self::IN_FULL->value,
                'name' => 'À vista',
                'description' => null,
            ],
            [
                'id' => self::ON_INSTALLMENTS->value,
                'name' => 'À prazo',
                'description' => null,
            ]
        ];
    }
}