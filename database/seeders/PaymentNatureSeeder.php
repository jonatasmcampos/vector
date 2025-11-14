<?php

namespace Database\Seeders;

use App\Enums\PaymentNatureEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentNatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = PaymentNatureEnum::getDataToInsert();
        foreach ($datas as $data) {
            DB::table('payment_natures')->updateOrInsert(
                ['id' => $data['id']],   
                [
                    'name' => $data['name'],
                    'description' => $data['description']
                ]
            );
        }
    }
}
