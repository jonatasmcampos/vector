<?php

namespace App\UseCases\PurchaseOrderItemHistory;

use App\DataTransferObjects\PurchaseOrderItemHistory\CreatePurchaseOrderItemHistoryDTO;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseOrderItemHistory;
use App\Repositories\PurchaseOrderItemHistoryRepository;

class CreatePurchaseOrderItemHistoryUseCase{

    private PurchaseOrderItemHistoryRepository $purchase_order_item_history_repository;

    public function __construct(
        PurchaseOrderItemHistoryRepository $purchase_order_item_history_repository
    ){
        $this->purchase_order_item_history_repository = $purchase_order_item_history_repository;
    }

    public function handle(CreatePurchaseOrderItemHistoryDTO $create_purchase_order_item_history_dto){
        return $this->manageAllItems($create_purchase_order_item_history_dto);
    }

    private function manageAllItems(CreatePurchaseOrderItemHistoryDTO $create_purchase_order_item_history_dto): void{
        $history_id = $create_purchase_order_item_history_dto->getHistoryId();
        $purchase_order_items = $create_purchase_order_item_history_dto->getPurchaseOrderItems();

        $purchase_order_items->each(function ($purchase_order_item) use ($history_id){
            $this->create($purchase_order_item, $history_id);
        });
    }

    private function create(PurchaseOrderItem $purchase_order_item, int $history_id): ?PurchaseOrderItemHistory{
        return $this->purchase_order_item_history_repository->create(
            $history_id,
            $purchase_order_item->id,
            $purchase_order_item->external_material_id,
            $purchase_order_item->material,
            $purchase_order_item->unit_amount,
            $purchase_order_item->total_amount,
            $purchase_order_item->quantity,
            $purchase_order_item->purchase_order_id,
            $purchase_order_item->contract_id
        );
    }
}