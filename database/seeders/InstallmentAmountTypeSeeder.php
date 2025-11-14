<?php

namespace Database\Seeders;

use App\Enums\InstallmentAmountTypeEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstallmentAmountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = InstallmentAmountTypeEnum::getDataToInsert();
        foreach ($datas as $data) {
            DB::table('installment_amount_types')->updateOrInsert(
                ['id' => $data['id']],   
                [
                    'name' => $data['name'],
                    'description' => $data['description']
                ]
            );
        }
    }
}
