<?php

namespace App\DataTransferObjects\PurchaseOrderHistory;

use App\Models\PurchaseOrder;

class CreatePurchaseOrderHistoryDTO
{
    private PurchaseOrder $purchase_order;
    private int $history_id;
    private int $credit_limit_id;

    public function __construct(
        PurchaseOrder $purchase_order,
        int $history_id,
        int $credit_limit_id
    ) {
        $this->purchase_order = $purchase_order;
        $this->history_id = $history_id;
        $this->credit_limit_id = $credit_limit_id;
    }

    public function getPurchaseOrder(): PurchaseOrder
    {
        return $this->purchase_order;
    }

    public function getHistoryId(): int
    {
        return $this->history_id;
    }

    public function getCreditLimitId(): int
    {
        return $this->credit_limit_id;
    }
}
