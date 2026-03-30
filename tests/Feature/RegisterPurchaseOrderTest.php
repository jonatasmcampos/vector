<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class RegisterPurchaseOrderTest extends TestCase
{
    use WithoutMiddleware;

    public function test_generate_massive_data(): void
    {
        $config = [
            ['mes' => 1, 'quantidade' => 10],
            ['mes' => 2, 'quantidade' => 16],
            ['mes' => 3, 'quantidade' => 25],
        ];

        $this->generateCreditLimits();

        $this->generatePurchaseOrders($config, 3, 2026);
    }

    private function generateCreditLimits(): void
    {

        $payload1 = [
            'contract_id' => 2,
            'authorized_amount' => '100000,00',
            'credit_usage_type_id' => 1,
            'credit_modality_id' => 1,
            'credit_period_type_id' => 1,
            'month' => 1,
        ];

        $payload2 = [
            'contract_id' => 2,
            'authorized_amount' => '70000,00',
            'credit_usage_type_id' => 1,
            'credit_modality_id' => 2,
            'credit_period_type_id' => 1,
            'month' => 1,
        ];

        $payload3 = [
            'contract_id' => 2,
            'authorized_amount' => '150000,00',
            'credit_usage_type_id' => 1,
            'credit_modality_id' => 1,
            'credit_period_type_id' => 1,
            'month' => 2,
        ];

        $payload4 = [
            'contract_id' => 2,
            'authorized_amount' => '100000,00',
            'credit_usage_type_id' => 1,
            'credit_modality_id' => 2,
            'credit_period_type_id' => 1,
            'month' => 2,
        ];

        $payload5 = [
            'contract_id' => 2,
            'authorized_amount' => '200000,00',
            'credit_usage_type_id' => 1,
            'credit_modality_id' => 1,
            'credit_period_type_id' => 1,
            'month' => 3,
        ];

        $payload6 = [
            'contract_id' => 2,
            'authorized_amount' => '150000,00',
            'credit_usage_type_id' => 1,
            'credit_modality_id' => 2,
            'credit_period_type_id' => 1,
            'month' => 3,
        ];


        $this->withSession([
            'user' => [
                'id' => 1
            ]
        ]);

        Carbon::setTestNow(Carbon::create(2026, 01, 1));
        $response1 = $this->postJson(env('APP_URL') . '/gerenciar/limites/novo', $payload1);
        $response1->assertStatus(200);
        $response2 = $this->postJson(env('APP_URL') . '/gerenciar/limites/novo', $payload2);
        $response2->assertStatus(200);
        Carbon::setTestNow(Carbon::create(2026, 02, 1));
        $response3 = $this->postJson(env('APP_URL') . '/gerenciar/limites/novo', $payload3);
        $response3->assertStatus(200);
        $response4 = $this->postJson(env('APP_URL') . '/gerenciar/limites/novo', $payload4);
        $response4->assertStatus(200);
        Carbon::setTestNow(Carbon::create(2026, 03, 1));
        $response5 = $this->postJson(env('APP_URL') . '/gerenciar/limites/novo', $payload5);
        $response5->assertStatus(200);
        $response6 = $this->postJson(env('APP_URL') . '/gerenciar/limites/novo', $payload6);
        $response6->assertStatus(200);
        Carbon::setTestNow();
    }


    private function generatePurchaseOrders(array $config, int $contractId, int $year): void
    {
        foreach ($config as $item) {

            $mes = $item['mes'];
            $quantidade = $item['quantidade'];

            $daysInMonth = Carbon::create($year, $mes)->daysInMonth;

            $dias = [];

            for ($i = 0; $i < $quantidade; $i++) {
                $dias[] = rand(1, $daysInMonth);
            }

            sort($dias);

            foreach ($dias as $dia) {

                $date = Carbon::create($year, $mes, $dia)
                    ->setTime(rand(8, 18), rand(0, 59), rand(0, 59)); 

                $this->gerarCompraDinamicaUmaPorVez($date, $contractId);
            }
        }
    }


    private function gerarCompraDinamicaUmaPorVez(Carbon $date, int $contractId): void
    {
      
        Carbon::setTestNow($date);

        try {

            $lastPurchaseOrder = DB::table('purchase_orders')
                ->orderByDesc('external_display_id')
                ->first();

            $materials = $this->generateMaterials();
            $total = collect($materials)->sum('total_amount');

            $installments = $this->generateInstallments($total);

            $payload = [
                "header" => [
                    "payload_type" => "ordem_de_compra",
                    "action_date" => Carbon::now()
                ],
                "payload" => [
                    "purchase_order" => [
                        "user_master_cod" => "50",
                        "contract_master_cod" => (int) $contractId,
                        "total" => $total,
                        "external_identifier" => rand(10000, 99999),
                        "purchase_order_type_id" => "1",
                        "external_display_id" => $lastPurchaseOrder
                            ? $lastPurchaseOrder->external_display_id + 1
                            : 1,
                        "total_items" => count($materials),
                        "cif" => "0",
                        "fob" => "0",
                        "supplier_id" => "1",
                        "discount" => "0",
                        "payment_nature_id" => rand(1, 5),
                        "payment_method_id" => rand(1, 2),
                        "installment_quantity" => count($installments),
                        "created_at" => Carbon::now()
                    ],
                    "materials" => $materials,
                    "installments" => $installments
                ]
            ];

            $response = $this->postJson(env('APP_URL') . '/api/purchase-order/store', $payload);

            $response->assertStatus(200);
        } finally {
            Carbon::setTestNow();
        }
    }

    /**
     * Gera materiais aleatórios
     */
    private function generateMaterials(): array
    {
        $materialsPool = [
            [
                "external_material_id" => "651",
                "material" => "SELANTE PU 400GR | UN | VEDACIT",
                "unit_amount" => 7.9
            ],
            [
                "external_material_id" => "652",
                "material" => "ARGAMASSA AC3 | 20KG | VOTORAN",
                "unit_amount" => 35.5
            ],
            [
                "external_material_id" => "653",
                "material" => "CIMENTO CP2 | 50KG | VOTORAN",
                "unit_amount" => 42.0
            ],
            [
                "external_material_id" => "654",
                "material" => "AREIA LAVADA | M3",
                "unit_amount" => 120
            ],
            [
                "external_material_id" => "655",
                "material" => "TIJOLO 8 FUROS | UN",
                "unit_amount" => 1.25
            ]
        ];

        shuffle($materialsPool);

        $quantity = rand(1, 5);

        $selected = array_slice($materialsPool, 0, $quantity);

        return array_map(function ($item) {

            $qty = rand(1, 50);
            $total = $qty * $item['unit_amount'];

            return [
                "external_material_id" => $item['external_material_id'],
                "material" => $item['material'],
                "quantity" => $qty,
                "unit_amount" => $item['unit_amount'],
                "total_amount" => round($total, 2)
            ];
        }, $selected);
    }

    private function generateInstallments(float $total): array
    {
        $quantity = rand(1, 3);

        $installments = [];
        $remaining = $total;

        for ($i = 1; $i <= $quantity; $i++) {

            if ($i == $quantity) {
                $amount = $remaining;
            } else {
                $amount = round($total / $quantity, 2);
                $remaining -= $amount;
            }

            $installments[] = [
                "installment_amount_type_id" => "2",
                "order" => $i,
                "installment_amount" => $amount,
                "installment_type_id" => "2",
                "due_day" => Carbon::now()->addDays(30 * $i)->format('Y-m-d'),
                "external_identifier" => rand(10, 999)
            ];
        }

        return $installments;
    }
}
