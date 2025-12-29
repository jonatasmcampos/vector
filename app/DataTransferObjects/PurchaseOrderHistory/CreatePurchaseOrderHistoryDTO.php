<?php

namespace App\DataTransferObjects\PurchaseOrderHistory;

use App\Models\CreditLimitBalance;
use App\Models\PurchaseOrder;

class CreatePurchaseOrderHistoryDTO
{
    private PurchaseOrder $purchase_order;
    private int $history_id;
    private CreditLimitBalance $credit_limit_balance;

    public function __construct(
        PurchaseOrder $purchase_order,
        int $history_id,
        CreditLimitBalance $credit_limit_balance
    ) {
        $this->purchase_order = $purchase_order;
        $this->history_id = $history_id;
        $this->credit_limit_balance = $credit_limit_balance;
    }

    public function getPurchaseOrder(): PurchaseOrder
    {
        return $this->purchase_order;
    }

    public function getHistoryId(): int
    {
        return $this->history_id;
    }

    public function getCreditLimitBalance(): CreditLimitBalance
    {
        return $this->credit_limit_balance;
    }
}
