<?php

namespace App\UseCases\PurchaseOrderItem;

use App\DataTransferObjects\PurchaseOrderItem\CreatePurchaseOrderItemDTO;
use App\Models\PurchaseOrderItem;
use App\Repositories\PurchaseOrderItemRepository;
use Illuminate\Database\Eloquent\Collection;

class CreatePurchaseOrderItemUseCase{

    private PurchaseOrderItemRepository $purchase_order_item_repository;

    public function __construct(
        PurchaseOrderItemRepository $purchase_order_item_repository
    ){
        $this->purchase_order_item_repository = $purchase_order_item_repository;   
    }

    /**
     * @return Collection<int, PurchaseOrderItem>
     */
    public function handle(CreatePurchaseOrderItemDTO $create_purchase_order_item_dto){
        return $this->manageAllMaterials($create_purchase_order_item_dto);
    }

    /**
     * @return Collection<int, PurchaseOrderItem>
     */
    private function manageAllMaterials(CreatePurchaseOrderItemDTO $create_purchase_order_item_dto): Collection{
        $materials = $create_purchase_order_item_dto->getMaterials();
        $purchase_order_items = array_map(function(array $material) use ($create_purchase_order_item_dto): PurchaseOrderItem{
            return $this->create(
                $material['external_material_id'],
                $material['material'],
                $material['unit_amount'],
                $material['total_amount'],
                $material['quantity'],
                $create_purchase_order_item_dto->getPurchaseOrderId(),
                $create_purchase_order_item_dto->getContractId()
            );
        }, $materials);
        return new Collection($purchase_order_items);
    }

    private function create(
        int $external_material_id,
        string $material,
        int $unit_amount,
        int $total_amount,
        int $quantity,
        int $purchase_order_id,
        int $contract_id
    ): PurchaseOrderItem{
        return $this->purchase_order_item_repository->create(
            $external_material_id,
            $material,
            $unit_amount,
            $total_amount,
            $quantity,
            $purchase_order_id,
            $contract_id
        );
    }
}