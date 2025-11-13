<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\CreditUsageTypeEnum;
use Illuminate\Support\Facades\DB;

class CreditUsageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = CreditUsageTypeEnum::getDataToInsert();
        foreach ($datas as $data) {
            DB::table('credit_usage_types')->updateOrInsert(
                ['id' => $data['id']],   
                [
                    'name' => $data['name'],
                    'description' => $data['description']
                ]
            );
        }
    }
}
