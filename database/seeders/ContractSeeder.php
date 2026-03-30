<?php

namespace Database\Seeders;

use App\Enums\ContractEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = ContractEnum::getDataToInsert();
        foreach ($datas as $data) {
            DB::table('contracts')->updateOrInsert(
                ['id' => $data['id']],   
                [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'contractor' => $data['contractor'],
                    'contract_master_cod' => $data['contract_master_cod'],
                    'code' => $data['code'],
                    'active' => $data['active'],
                ],
            );
        }
    }
}
