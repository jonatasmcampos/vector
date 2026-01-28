<?php

namespace App\Models;

use App\Enums\CreditModalityEnum;
use Illuminate\Database\Eloquent\Model;

class CreditLimit extends Model
{
    protected $table = 'credit_limits';
    protected $fillable = [
        'authorized_amount',
        'month',
        'year',
        'contract_id',
        'credit_usage_type_id',
        'credit_modality_id',
        'credit_period_type_id',
        'active'
    ];
    
    protected function casts(): array
    {
        return [
            'authorized_amount' => 'integer',
            'month' => 'integer',
            'year' => 'integer',
            'contract_id' => 'integer',
            'credit_usage_type_id' => 'integer',
            'credit_modality_id' => 'integer',
            'credit_period_type_id' => 'integer',
            'active' => 'boolean'
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
        return $this->belongsTo(CreditUsageType::class, 'credit_period_type_id', 'id');
    }

    public function monthly_credit_limit_balance(){
        return $this->hasOne(MonthlyCreditLimitBalance::class, 'credit_limit_id', 'id');
    }

    public function isAcquisitionModality(): bool
    {
        return $this->credit_modality_id === CreditModalityEnum::ACQUISITION->value;
    }

    public function isPaymentModality(): bool
    {
        return $this->credit_modality_id === CreditModalityEnum::PAYMENT->value;
    }

    public function credit_limit_histories()
    {
        return $this->hasMany(CreditLimitHistory::class, 'credit_limit_id', 'id');
    }
}
