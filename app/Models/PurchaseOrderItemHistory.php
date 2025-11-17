<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItemHistory extends Model
{
    protected $fillable = [
        'history_id',
        'external_material_id',
        'material',
        'unit_amount',
        'total_amount',
        'quantity',
        'purchase_order_id',
    ];

    public function history()
    {
        return $this->belongsTo(History::class, 'history_id', 'id');
    }
    public function purchase_order()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id', 'id');
    }
}
