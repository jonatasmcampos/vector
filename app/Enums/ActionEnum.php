<?php

namespace App\Enums;

enum ActionEnum: int
{
    case MANAGE_CREATE_CREDIT_LIMIT = 1;
    case MANAGE_CREATE_CREDIT_LIMIT_BALANCE = 2;

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
            ]
        ];
    }
}