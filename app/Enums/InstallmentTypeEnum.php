<?php

namespace App\Enums;

enum InstallmentTypeEnum: int
{
    case DOWN_PAYMENT = 1;
    case SUBSEQUENT_INSTALLMENTS = 2;

    public static function getDataToInsert(): array{
        return [
            [
                'id' => self::DOWN_PAYMENT->value,
                'name' => 'Entrada',
                'description' => 'Valor inicial a vista ao realizar uma compra.',
            ],
            [
                'id' => self::SUBSEQUENT_INSTALLMENTS->value,
                'name' => 'Parcelas subsequentes',
                'description' => 'Valores restantes a serem quitados.',
            ]
        ];
    }
}