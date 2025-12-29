<?php

namespace App\DataTransferObjects\PurchaseOrder;

class CreatePurchaseOrderDTO {
    private array $header;
    private array $purchase_order_data;
    private array $materials;
    private array $installments;

    public function __construct(
        array $header,
        array $purchase_order_data,
        array $materials,
        array $installments
    ) {
        $this->header               = $header;
        $this->purchase_order_data  = $purchase_order_data;
        $this->materials            = $materials;
        $this->installments         = $installments;
    }

    public function getHeader(): array
    {
        return $this->header;
    }

    public function getPurchaseOrderData(): array
    {
        return $this->purchase_order_data;
    }

    public function getMaterials(): array
    {
        return $this->materials;
    }

    public function getInstallments(): array
    {
        return $this->installments;
    }
}