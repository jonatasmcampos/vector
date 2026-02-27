<?php

namespace App\Enums;

enum ContractEnum: int
{
    case ALL = 99; 
    case CT5 = 1;
    case CT6 = 2;

    public static function getAll(?bool $is_full_name = true){
        return [
            self::CT5->value => ($is_full_name ? '[CT05] 201/2020 - Pref. Municipal de Anápolis' : 'CT5'),
            self::CT6->value => ($is_full_name ? '[CT06] 976/2020  - Pref. Municipal de Aparecida de Goiânia' : 'CT6'),
        ];
    }

    public static function getDataToInsert(): array
    {
        return [
            [
                'id' => self::ALL->value,
                'name' => 'ação em todos os contratos',
                'description' => 'referente a mudanças que causem efeitos em todos os contratos',
                'contractor' => null,
                'contract_master_cod' => 99,
                'code' => 'todos',
                'active' => true,
            ],
            [
                'id' => self::CT5->value,
                'name' => '[CT05] 201/2020 - Pref. Municipal de Anápolis',
                'description' => 'Anápolis',
                'contractor' => null,
                'contract_master_cod' => 2,
                'code' => 'ct5',
                'active' => true,
            ],
            [
                'id' => self::CT6->value,
                'name' => '[CT06] 976/2020  - Pref. Municipal de Aparecida de Goiânia',
                'description' => null,
                'contractor' => null,
                'contract_master_cod' => 3,
                'code' => 'ct6',
                'active' => true,
            ],
        ];
    }
}