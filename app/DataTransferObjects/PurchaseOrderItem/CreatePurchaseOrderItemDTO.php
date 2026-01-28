<?php

namespace App\DataTransferObjects\PurchaseOrderItem;

class CreatePurchaseOrderItemDTO
{
    private array $materials;
    private int $purchase_order_id;
    private int $contract_id;

    public function __construct(
        array $materials,
        int $purchase_order_id,
        int $contract_id
    ) {
        $this->materials = $materials;
        $this->purchase_order_id = $purchase_order_id;
        $this->contract_id = $contract_id;
    }

    public function getMaterials(): array
    {
        return $this->materials;
    }

    public function getPurchaseOrderId(): int
    {
        return $this->purchase_order_id;
    }

    public function getContractId(): int
    {
        return $this->contract_id;
    }
}
