<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $suppliers = [
            [
                'name'          => 'Fornecedor Exemplo LTDA',
                'trade_name'    => 'Fornecedor Exemplo',
                'document'      => '12345678000199',
                'mobile_phone'  => '11999999999',
                'phone'         => '1133334444',
                'email'         => 'contato@exemplo.com',
                'website'       => 'https://www.exemplo.com',
                'address_id'    => 1,
                'active'        => true,
            ],
            [
                'name'          => 'João da Silva',
                'trade_name'    => 'JS Serviços',
                'document'      => '12345678901',
                'mobile_phone'  => '11988888888',
                'phone'         => null,
                'email'         => 'joao@example.com',
                'website'       => null,
                'address_id'    => 2,
                'active'        => true,
            ],
        ];

        foreach ($suppliers as $data) {
            Supplier::updateOrCreate(
                ['document' => $data['document']], 
                $data
            );
        }
    }
}
