<?php

namespace App\Repositories;

use App\Models\PurchaseOrderItemHistory;

class PurchaseOrderItemHistoryRepository{
    public function create(
        int $history_id,
        int $purchase_order_item_id,
        int $external_material_id,
        string $material,
        int $unit_amount,
        int $total_amount,
        int $quantity,
        int $purchase_order_id,
        int $contract_id,
    ){
        return PurchaseOrderItemHistory::create([
            'history_id' => $history_id,
            'purchase_order_item_id' => $purchase_order_item_id,
            'external_material_id' => $external_material_id,
            'material' => $material,
            'unit_amount' => $unit_amount,
            'total_amount' => $total_amount,
            'quantity' => $quantity,
            'purchase_order_id' => $purchase_order_id,
            'contract_id' => $contract_id
        ]);
    }
}