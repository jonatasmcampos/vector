<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    protected $fillable = [
        'external_material_id',
        'material',
        'unit_amount',
        'total_amount',
        'quantity',
        'purchase_order_id',
        'contract_id'
    ];

    public function purchase_order()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id', 'id');
    }
}
