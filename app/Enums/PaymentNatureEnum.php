<?php

namespace App\Enums;

enum PaymentNatureEnum: int
{
    case BANK_SLIP = 1;
    case CARD = 2;
    case PIX = 3;
    case CASH = 4;
    case BANK_TRANSFER = 5;

    public static function getDataToInsert(): array{
        return [
            [
                'id' => self::BANK_SLIP->value,
                'name' => 'Boleto',
                'description' => null,
            ],
            [
                'id' => self::CARD->value,
                'name' => 'Cartão',
                'description' => null,
            ],
            [
                'id' => self::PIX->value,
                'name' => 'PIX',
                'description' => null,
            ],
            [
                'id' => self::CASH->value,
                'name' => 'Dinheiro',
                'description' => null,
            ],
            [
                'id' => self::BANK_TRANSFER->value,
                'name' => 'Transferência',
                'description' => null,
            ]
        ];
    }
}