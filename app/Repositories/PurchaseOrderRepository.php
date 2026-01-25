<?php

namespace App\Repositories;

use App\Models\PurchaseOrder;

class PurchaseOrderRepository{
    public function create(
        int $total,
        int $external_identifier,
        int $purchase_order_type_id,
        int $contract_id,
        int $external_display_id,
        int $status_id,
        int $total_items,
        int $cif,
        int $fob,
        int $user_id,
        int $supplier_id,
        int $discount,
        int $payment_nature_id,
        int $payment_method_id,
        int $installments_number
    ){
        return PurchaseOrder::create([
            'total' => $total,
            'external_identifier' => $external_identifier,
            'purchase_order_type_id' => $purchase_order_type_id,
            'contract_id' => $contract_id,
            'external_display_id' => $external_display_id,
            'status_id' => $status_id,
            'total_items' => $total_items,
            'cif' => $cif,
            'fob' => $fob,
            'user_id' => $user_id,
            'supplier_id' => $supplier_id,
            'discount' => $discount,
            'payment_nature_id' => $payment_nature_id,
            'payment_method_id' => $payment_method_id,
            'installments_number' => $installments_number,
        ]);
    }

    public function getById(
        int $purchase_order_id
    ): ?PurchaseOrder{
        $purchase_order = PurchaseOrder::with([
            'user',
            'supplier',
            'installments',
            'purchase_order_items',
            'status',
            'contract'
        ])->find($purchase_order_id);
        if(!$purchase_order){
            throw new \Exception("Ordem de compra não encontrada", 404);
        } 
        return $purchase_order;
    }
}