<?php

namespace App\UseCases\PurchaseOrderHistory;

use App\DataTransferObjects\PurchaseOrderHistory\CreatePurchaseOrderHistoryDTO;
use App\Repositories\PurchaseOrderHistoryRepository;

class CreatePurchaseOrderHistoryUseCase{

    private PurchaseOrderHistoryRepository $purchase_order_history_repository;

    public function __construct(
        PurchaseOrderHistoryRepository $purchase_order_history_repository
    ){
        $this->purchase_order_history_repository = $purchase_order_history_repository;
    }

    public function handle(CreatePurchaseOrderHistoryDTO $create_purchase_order_history_dto){
        return $this->create($create_purchase_order_history_dto);
    }

    private function create(CreatePurchaseOrderHistoryDTO $create_purchase_order_history_dto){
        return $this->purchase_order_history_repository->create(
            $create_purchase_order_history_dto->getHistoryId(),
            $create_purchase_order_history_dto->getPurchaseOrder()->id,
            $create_purchase_order_history_dto->getPurchaseOrder()->total,
            $create_purchase_order_history_dto->getPurchaseOrder()->external_identifier,
            $create_purchase_order_history_dto->getPurchaseOrder()->purchase_order_type_id,
            $create_purchase_order_history_dto->getCreditLimitId(),
            $create_purchase_order_history_dto->getPurchaseOrder()->contract_id,
            $create_purchase_order_history_dto->getPurchaseOrder()->external_display_id,
            $create_purchase_order_history_dto->getPurchaseOrder()->status_id,
            $create_purchase_order_history_dto->getPurchaseOrder()->total_items,
            $create_purchase_order_history_dto->getPurchaseOrder()->cif,
            $create_purchase_order_history_dto->getPurchaseOrder()->fob,
            $create_purchase_order_history_dto->getPurchaseOrder()->user_id,
            $create_purchase_order_history_dto->getPurchaseOrder()->supplier_id,
            $create_purchase_order_history_dto->getPurchaseOrder()->discount,
            $create_purchase_order_history_dto->getPurchaseOrder()->payment_nature_id,
            $create_purchase_order_history_dto->getPurchaseOrder()->payment_method_id,
            $create_purchase_order_history_dto->getPurchaseOrder()->installments_number
        );
    }
}