<?php

namespace Database\Seeders;

use App\Enums\PurchaseOrderTypeEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchaseOrderTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = PurchaseOrderTypeEnum::getDataToInsert();
        foreach ($datas as $data) {
            DB::table('purchase_order_types')->updateOrInsert(
                ['id' => $data['id']],   
                [
                    'name' => $data['name'],
                    'description' => $data['description']
                ]
            );
        }
    }
}
