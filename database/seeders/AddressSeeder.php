<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $addresses = [
            [
                'street'             => 'Rua das Flores',
                'number'             => '123',
                'address_complement' => 'Apto 12',
                'neighborhood'       => 'Centro',
                'city'               => 'São Paulo',
                'state'              => 'SP',
                'postal_code'        => '01001000',
            ],
            [
                'street'             => 'Avenida Brasil',
                'number'             => '5000',
                'address_complement' => null,
                'neighborhood'       => 'Jardim América',
                'city'               => 'Rio de Janeiro',
                'state'              => 'RJ',
                'postal_code'        => '22250040',
            ],
        ];

        foreach ($addresses as $data) {
            Address::updateOrCreate(
                [
                    'street'      => $data['street'],
                    'number'      => $data['number'],
                    'city'        => $data['city'],
                    'postal_code' => $data['postal_code'],
                ],
                $data
            );
        }
    }
}
