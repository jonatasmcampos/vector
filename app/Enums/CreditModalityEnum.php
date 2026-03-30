<?php

namespace App\Enums;

enum CreditModalityEnum: int
{
    case ACQUISITION = 1;
    case PAYMENT = 2;

    public static function getAll(){
        return [
            self::ACQUISITION->value => 'Aquisição',
            self::PAYMENT->value => 'Pagamento',
        ];
    }

    public static function getDataToInsert(): array
    {
        return [
            [
                'id' => self::ACQUISITION->value,
                'name' => 'Aquisição',
                'description' => 'Finalidade de adquirir bens ou serviços.',
            ],
            [
                'id' => self::PAYMENT->value,
                'name' => 'Pagamento',
                'description' => 'Finalidade de pagar de bens ou serviços.',
            ],
        ];
    }
}