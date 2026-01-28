<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyCreditLimitBalance extends Model
{
    protected $table = 'monthly_credit_limit_balances';
    protected $fillable = [
        'total_used_amount',
        'balance',
        'credit_limit_id',
        'contract_id'
    ];
    
    protected function casts(): array
    {
        return [
            'total_used_amount' => 'integer',
            'balance' => 'integer',
            'credit_limit_id' => 'integer',
            'contract_id' => 'integer'
        ];
    }

    public function contract(){
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }

    public function credit_limit(){
        return $this->belongsTo(CreditLimit::class, 'credit_limit_id', 'id');
    }

}
