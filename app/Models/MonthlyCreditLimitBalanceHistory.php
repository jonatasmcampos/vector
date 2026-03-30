<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyCreditLimitBalanceHistory extends Model
{
    protected $table = 'monthly_credit_limit_balance_histories';
    protected $fillable = [
        'date',
        'used_amount',
        'old_used_amount',
        'new_used_amount',
        'old_balance',
        'new_balance',
        'monthly_credit_limit_balance_id',
        'history_id',
        'contract_id',
    ];
    
    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'used_amount' => 'integer',
            'old_used_amount' => 'integer',
            'new_used_amount' => 'integer',
            'old_balance' => 'integer',
            'new_balance' => 'integer',
            'monthly_credit_limit_balance_id' => 'integer',
            'history_id' => 'integer',
            'contract_id' => 'integer',
        ];
    }

    public function contract(){
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }

    public function monthly_credit_limit_balance(){
        return $this->belongsTo(MonthlyCreditLimitBalance::class, 'monthly_credit_limit_balance_id', 'id');
    }

    public function history(){
        return $this->belongsTo(History::class, 'history_id', 'id');
    }
}
