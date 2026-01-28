<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'amount',
        'transaction_type_id',
        'date',
        'user_id',
        'contract_id',
        'credit_limit_id',
        'installment_id',
        'transaction_entity_type',
        'transaction_entity_id',
        'balance_history_type',
        'balance_history_id'
    ];

    protected $casts = [
        'date' => 'datetime',
        'amount'=> 'integer',
    ];

    public function transaction_type()
    {
        return $this->belongsTo(TransactionType::class, 'transaction_type_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }

    public function credit_limit(){
        return $this->belongsTo(CreditLimit::class, 'credit_limit_id', 'id');
    }

    public function installment(){
        return $this->belongsTo(Installment::class);
    }

    public function transaction_entity()
    {
        return $this->morphTo();
    }

    public function balance_history()
    {
        return $this->morphTo();
    }
}
