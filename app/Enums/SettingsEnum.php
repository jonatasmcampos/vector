<?php

namespace App\Enums;

enum SettingsEnum: string
{
    case VALIDATE_PURCHASE_ORDER_PAYMENT_BALANCE_ON_ACQUISITION = 'validate-balance.purchase-order-payment-on-acquisition';   
    case LIMIT_SUPPLY_PERIOD_TYPE = 'limit.supply-period-type';

    public static function getDataToInsert(): array{
        return [
            [
                'id' => 1,
                'key' => self::VALIDATE_PURCHASE_ORDER_PAYMENT_BALANCE_ON_ACQUISITION->value,
                'value' => true,
                'group_name' => 'validate-balance'
            ],
            [
                'id' => 2,
                'key' => self::LIMIT_SUPPLY_PERIOD_TYPE->value,
                'value' => 'monthly',
                'group_name' => 'limit'
            ],
        ];
    }
}