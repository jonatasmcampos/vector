<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contracts = [
            [
                'name' => '[CT05] 201/2020 - Pref. Municipal de Anápolis',
                'description' => 'Anápolis',
                'contractor' => null,
                'contract_master_cod' => 2,
                'code' => 'ct5',
                'active' => true,
            ],
            [
                'name' => '[CT06] 976/2020  - Pref. Municipal de Aparecida de Goiânia',
                'description' => null,
                'contractor' => null,
                'contract_master_cod' => 3,
                'code' => 'ct6',
                'active' => true,
            ],
        ];

        DB::table('contracts')->insert($contracts);
    }
}
