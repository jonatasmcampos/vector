<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditLimitHistory extends Model
{
    protected $table = 'credit_limit_histories';
    protected $fillable = [
        'authorized_amount',
        'old_authorized_amount',
        'new_authorized_amount',
        'date',
        'credit_limit_id',
        'history_id',
        'contract_id',
        'credit_usage_type_id',
        'credit_modality_id',
        'credit_period_type_id'
    ];
    
    protected function casts(): array
    {
        return [
            'authorized_amount' => 'integer',
            'old_authorized_amount' => 'integer',
            'new_authorized_amount' => 'integer',
            'date' => 'datetime',
            'credit_limit_id' => 'integer',
            'history_id' => 'integer',
            'contract_id' => 'integer',
            'credit_usage_type_id' => 'integer',
            'credit_modality_id' => 'integer',
            'credit_period_type_id' => 'integer',
        ];
    }

    public function contract(){
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }

    public function credit_usage_type(){
        return $this->belongsTo(CreditUsageType::class, 'credit_usage_type_id', 'id');
    }

    public function credit_modality(){
        return $this->belongsTo(CreditModality::class, 'credit_modality_id', 'id');
    }

    public function credit_period_type(){
        return $this->belongsTo(CreditPeriodType::class, 'credit_period_type_id', 'id');
    }

    public function credit_limit(){
        return $this->belongsTo(CreditLimit::class, 'credit_limit_id', 'id');
    }

    public function history(){
        return $this->belongsTo(History::class, 'history_id', 'id');
    }

}
