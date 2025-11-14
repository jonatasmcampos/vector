<?php

namespace Database\Seeders;

use App\Enums\OriginEntityEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OriginEntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = OriginEntityEnum::getDataToInsert();
        foreach ($datas as $data) {
            DB::table('origin_entities')->updateOrInsert(
                ['id' => $data['id']],   
                [
                    'name' => $data['name'],
                    'description' => $data['description']
                ]
            );
        }
    }
}
