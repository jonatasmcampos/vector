<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'transaction_type_id',
        'amount',
        'origin_entity_id',
        'origin_entity_identifier',
        'payment_nature_id',
        'payment_method_id',
        'installments_number',
        'user_id',
        'contract_id',
        'date',
        'parent_transaction_id',
    ];

    protected $casts = [
        'date' => 'datetime',
        'amount'=> 'integer',
    ];

    public function transaction_type()
    {
        return $this->belongsTo(TransactionType::class);
    }

    public function payment_nature()
    {
        return $this->belongsTo(PaymentNature::class);
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function parent_transaction()
    {
        return $this->belongsTo(Transaction::class, 'parent_transaction_id');
    }

    public function child_transactions()
    {
        return $this->hasMany(Transaction::class, 'parent_transaction_id');
    }
}
