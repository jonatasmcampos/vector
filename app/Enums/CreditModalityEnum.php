<?php

namespace App\Enums;

enum CreditModalityEnum: int
{
    case AQUISICAO = 1;
    case PAGAMENTO = 2;

    public static function getAll(){
        return [
            self::AQUISICAO->value => 'Aquisição',
            self::PAGAMENTO->value => 'Pagamento',
        ];
    }

    public static function getDataToInsert(): array
    {
        return [
            [
                'id' => self::AQUISICAO->value,
                'name' => 'Aquisição',
                'description' => 'Finalidade de adquirir bens ou serviços.',
            ],
            [
                'id' => self::PAGAMENTO->value,
                'name' => 'Pagamento',
                'description' => 'Finalidade de pagar de bens ou serviços.',
            ],
        ];
    }
}