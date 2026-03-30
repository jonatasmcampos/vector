<?php

namespace App\DataTransferObjects\PurchaseOrderItemHistory;

use Illuminate\Database\Eloquent\Collection;
use App\Models\PurchaseOrderItem;

class CreatePurchaseOrderItemHistoryDTO
{
    /**
     * @var Collection<int, PurchaseOrderItem>
     */
    private Collection $purchase_order_items;
    private int $history_id;

    public function __construct(
        Collection $purchase_order_items,
        int $history_id
    ) {
        $this->purchase_order_items = $purchase_order_items;
        $this->history_id = $history_id;
    }

    /**
     * @return Collection<int, PurchaseOrderItem>
     */
    public function getPurchaseOrderItems(): Collection
    {
        return $this->purchase_order_items;
    }

    public function getHistoryId(): int
    {
        return $this->history_id;
    }

}
