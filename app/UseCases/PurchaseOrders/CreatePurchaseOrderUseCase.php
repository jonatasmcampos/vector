<?php

namespace App\UseCases\PurchaseOrders;

use App\DataTransferObjects\PurchaseOrder\CreatePurchaseOrderDTO;
use App\Domain\Mappers\ContractIdMapper;
use App\Domain\Mappers\UserIdMapper;
use App\Domain\ValueObjects\AmountInCents;
use App\Enums\StatusEnum;
use App\Models\PurchaseOrder;
use App\Repositories\PurchaseOrderRepository;

class CreatePurchaseOrderUseCase {

    private PurchaseOrderRepository $purchase_order_repository;

    public function __construct(
        PurchaseOrderRepository $purchase_order_repository
    ){
        $this->purchase_order_repository = $purchase_order_repository;        
    }
    
    public function handle(CreatePurchaseOrderDTO $create_purchase_order_dto){
        $user_id = UserIdMapper::fromUserMasterCod($create_purchase_order_dto->getPurchaseOrderData()['user_master_cod']);
      
        return $this->createPurchaseOrder(
            AmountInCents::fromFloat($create_purchase_order_dto->getPurchaseOrderData()['total'])->value(),
            $create_purchase_order_dto->getPurchaseOrderData()['external_identifier'],
            $create_purchase_order_dto->getPurchaseOrderData()['purchase_order_type_id'],
            ContractIdMapper::fromContractMasterCod($create_purchase_order_dto->getPurchaseOrderData()['contract_master_cod']),
            $create_purchase_order_dto->getPurchaseOrderData()['external_display_id'],
            StatusEnum::PENDING->value,
            $create_purchase_order_dto->getPurchaseOrderData()['total_items'],
            AmountInCents::fromFloat($create_purchase_order_dto->getPurchaseOrderData()['cif'])->value(),
            AmountInCents::fromFloat($create_purchase_order_dto->getPurchaseOrderData()['fob'])->value(),
            $user_id,
            $create_purchase_order_dto->getPurchaseOrderData()['supplier_id'],
            AmountInCents::fromFloat($create_purchase_order_dto->getPurchaseOrderData()['discount'])->value(),
            $create_purchase_order_dto->getPurchaseOrderData()['payment_nature_id'],
            $create_purchase_order_dto->getPurchaseOrderData()['payment_method_id'],
            $create_purchase_order_dto->getPurchaseOrderData()['installment_quantity']
        );
    }

    private function createPurchaseOrder(
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
    ): PurchaseOrder{
        return $this->purchase_order_repository->create(
            $total,
            $external_identifier,
            $purchase_order_type_id,
            $contract_id,
            $external_display_id,
            $status_id,
            $total_items,
            $cif,
            $fob,
            $user_id,
            $supplier_id,
            $discount,
            $payment_nature_id,
            $payment_method_id,
            $installments_number
        );
    }
}