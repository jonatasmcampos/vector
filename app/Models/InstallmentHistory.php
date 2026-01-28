<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstallmentHistory extends Model
{
    protected $table = 'installment_histories';

    protected $fillable = [
        'history_id',
        'installment_amount',
        'due_day',
        'order',
        'paid_at',
        'amount_paid',
        'external_identifier',
        'installment_amount_type_id',
        'installment_type_id',
        'installment_id',
        'contract_id'
    ];

    protected $casts = [
        'history_id' => 'integer',
        'installment_amount' => 'integer',
        'amount_paid' => 'integer',
        'paid_at' => 'datetime',
        'due_day' => 'date',
        'installment_id' => 'integer',
        'contract_id' => 'integer'
    ];

    public function history(){
        return $this->belongsTo(History::class, 'history_id', 'id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function installment_amount_type()
    {
        return $this->belongsTo(InstallmentAmountType::class, 'installment_amount_type_id', 'id');
    }

    public function installment_type()
    {
        return $this->belongsTo(InstallmentType::class, 'installment_type_id', 'id');
    }

    public function installment(){
        return $this->belongsTo(Installment::class, 'installment_id', 'id');
    }

}
