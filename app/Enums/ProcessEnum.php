<?php

namespace App\Enums;

enum ProcessEnum: int
{
    case DASHBOARD = 1;
    case MANAGE_LIMIT = 2;
    case SETTINGS = 3;
    case EXTERNAL_PURCHASE_ORDER_CREATION = 4;

    public static function getDataToInsert(): array{
        return [
            [
                'id' => self::DASHBOARD->value,
                'name' => 'Dashboard',
                'description' => null,
                'route' => 'view.home',
                'order' => 1,
                'menu' => 'DASHBOARD',
                'icon' => 'bi bi-speedometer2',
                'process' => 'dashboard'
            ],
            [
                'id' => self::MANAGE_LIMIT->value,
                'name' => 'Limites',
                'description' => null,
                'route' => 'manage.limits.index',
                'order' => 1,
                'menu' => 'GERENCIAR',
                'icon' => 'bi bi-coin',
                'process' => 'limites'
            ],
            [
                'id' => self::SETTINGS->value,
                'name' => 'Configurações',
                'description' => null,
                'route' => 'config.config.index',
                'order' => 1,
                'menu' => 'CONFIGURAÇÃO',
                'icon' => 'bi bi-gear',
                'process' => 'config'
            ],
            [
                'id' => self::EXTERNAL_PURCHASE_ORDER_CREATION->value,
                'name' => 'Listagem de ordem de compra',
                'description' => null,
                'route' => 'config.config.index',
                'order' => 1,
                'menu' => 'DADOS EXTERNOS',
                'icon' => 'bi bi-gear',
                'process' => 'purchase_order'
            ],
        ];
    }
}