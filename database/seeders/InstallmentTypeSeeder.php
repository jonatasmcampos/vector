<?php

namespace Database\Seeders;

use App\Enums\InstallmentTypeEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstallmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = InstallmentTypeEnum::getDataToInsert();
        foreach ($datas as $data) {
            DB::table('installment_types')->updateOrInsert(
                ['id' => $data['id']],   
                [
                    'name' => $data['name'],
                    'description' => $data['description']
                ]
            );
        }
    }
}
