<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $table = 'installments';

    protected $fillable = [
        'installment_amount',
        'due_day',
        'order',
        'paid_at',
        'amount_paid',
        'external_identifier',
        'installment_amount_type_id',
        'installment_type_id',
        'contract_id'
    ];

    protected $casts = [
        'installment_amount' => 'integer',
        'amount_paid' => 'integer',
        'paid_at' => 'datetime',
        'due_day' => 'date',
        'contract_id' => 'integer'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(Transaction::class, 'status_id', 'id');
    }

    public function installment_amount_type()
    {
        return $this->belongsTo(Transaction::class, 'installment_amount_type_id', 'id');
    }

    public function installment_type()
    {
        return $this->belongsTo(Transaction::class, 'installment_type_id', 'id');
    }

    public function owning_entity()
    {
        return $this->morphTo();
    }

    public function installment_history(){
        return $this->hasOne(InstallmentHistory::class);
    }
}
