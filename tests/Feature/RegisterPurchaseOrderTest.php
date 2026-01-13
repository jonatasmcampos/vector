<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RegisterPurchaseOrderTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $payload = [
            "header" => [
                "payload_type" => "ordem_de_compra",
                "action_date" => "2026-01-01T12:23:38.000000Z"
            ],
            "payload" => [
                "purchase_order" => [
                    "user_master_cod" => "50",
                    "contract_master_cod" => "3",
                    // "total" => "284.39",
                    "total" => "8000.00",
                    "external_identifier" => "89524",
                    "purchase_order_type_id" => "1",
                    "external_display_id" => "5356",
                    "total_items" => "1",
                    "cif" => "0",
                    "fob" => "0",
                    "supplier_id" => "1",
                    "discount" => "0",
                    "payment_nature_id" => "2",
                    "payment_method_id" => "2",
                    "installment_quantity" => "3",
                    "created_at" => "2026-01-01T12:23:38.000000Z"
                ],
                "materials" => [
                    [
                        "external_material_id" => "651",
                        "material" => "SELANTE PU 400GR | UN | VEDACIT",
                        "quantity" => "36",
                        "unit_amount" => "7.9",
                        "total_amount" => "284.4"
                    ]
                ],
                "installments" => [
                    [
                        "installment_amount_type_id" => "2",
                        "order" => "1",
                        "installment_amount" => "100",
                        "installment_type_id" => "2",
                        "due_day" => "2025-12-10",
                        "external_identifier" => "60"
                    ],
                    [
                        "installment_amount_type_id" => "2",
                        "order" => "1",
                        "installment_amount" => 57.90,
                        "installment_type_id" => "2",
                        "due_day" => "2025-12-30",
                        "external_identifier" => "60"
                    ],
                    [
                        "installment_amount_type_id" => "2",
                        "order" => "2",
                        "installment_amount" => "93.85",
                        "installment_type_id" => "2",
                        "due_day" => "2026-01-18",
                        "external_identifier" => "68"
                    ],
                    [
                        "installment_amount_type_id" => "2",
                        "order" => "3",
                        "installment_amount" => "93.85",
                        "installment_type_id" => "2",
                        "due_day" => "2026-02-17",
                        "external_identifier" => "69"
                    ]
                ]
            ]
        ];
        $response = $this->postJson(env('APP_URL').'/api/purchase_order/store', $payload);
        dd($response->json());
        $response->assertStatus(200);
    }
}
