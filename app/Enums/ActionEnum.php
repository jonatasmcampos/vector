<?php

namespace App\Enums;

enum ActionEnum: int
{
    case MANAGE_CREATE_CREDIT_LIMIT = 1;
    case MANAGE_CREATE_CREDIT_LIMIT_BALANCE = 2;
    case PURCHASE_GENERATED = 3;
    case CREDIT_LIMIT_BALANCE_UPDATED = 4;
    case BALANCE_VALIDATION_SETTINGS_UPDATED = 5;
    case CREDIT_LIMITS_SETTINGS_UPDATED = 6;

    public static function getDataToInsert(): array{
        return [
            [
                'id' => self::MANAGE_CREATE_CREDIT_LIMIT->value,
                'name' => 'cadastrou limite de crédito',
                'description' => 'cadastrou um novo limite',
            ],
            [
                'id' => self::MANAGE_CREATE_CREDIT_LIMIT_BALANCE->value,
                'name' => 'cadastrou saldo do limite de crédito',
                'description' => 'cadastrou um novo saldo para o limite',
            ],
            [
                'id' => self::PURCHASE_GENERATED->value,
                'name' => 'compra gerada',
                'description' => 'foi realizada uma compra',
            ],
            [
                'id' => self::CREDIT_LIMIT_BALANCE_UPDATED->value,
                'name' => 'limite de crédito atualizado',
                'description' => 'foi atualizado o limite de crédito',
            ],
            [
                'id' => self::BALANCE_VALIDATION_SETTINGS_UPDATED->value,
                'name' => 'configuração de validação de saldo atualizada',
                'description' => 'foi atualizada a configuração de validação de saldo',
            ],
            [
                'id' => self::CREDIT_LIMITS_SETTINGS_UPDATED->value,
                'name' => 'configuração de limite de crédito atualizada',
                'description' => 'foi atualizada a configuração de limite de crédito',
            ],
        ];
    }
}