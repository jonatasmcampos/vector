<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderHistory extends Model
{
    protected $table = 'purchase_order_histories';
    protected $fillable = [
        'history_id',
        'total',
        'external_identifier',
        'purchase_order_type_id',
        'credit_limit_id',
        'contract_id',
        'external_display_id',
        'status_id',
        'total_items',
        'cif',
        'fob',
        'user_id',
        'supplier_id',
        'discount',
        'payment_nature_id',
        'payment_method_id',
        'installments_number',
    ];

    public function history(){
        return $this->belongsTo(History::class, 'history_id', 'id');
    }
    public function purchase_order_type(){
        return $this->belongsTo(PurchaseOrderType::class, 'purchase_order_type_id', 'id');
    }
    public function credit_limit(){
        return $this->belongsTo(CreditLimit::class, 'credit_limit_id', 'id');
    }
    public function contract(){
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }
    public function status(){
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function supplier(){
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }
    public function payment_nature(){
        return $this->belongsTo(PaymentNature::class, 'payment_nature_id', 'id');
    }
    public function payment_method(){
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }
    public function purchase_order_items(){
        return $this->hasMany(PurchaseOrderItem::class);
    }
}
