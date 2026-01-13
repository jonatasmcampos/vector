<?php

namespace App\Repositories;

use App\Models\CreditLimit;
use Carbon\Carbon;

class CreditLimitRepository {
    public function create(
        int $authorized_amount,
        int $month,
        int $contract_id,
        int $credit_usage_type_id,
        int $credit_modality_id,
        int $credit_period_type_id
    ): CreditLimit{
        return CreditLimit::create([
            'authorized_amount' => $authorized_amount,
            'month' => $month,
            'year' => (int)Carbon::now()->format('Y'),
            'contract_id' => $contract_id,
            'credit_usage_type_id' => $credit_usage_type_id,
            'credit_modality_id' => $credit_modality_id,
            'credit_period_type_id' => $credit_period_type_id,
            'active' => true
        ]);
    }

    public function getByMonthYearContractIdAndUsageTypeId(
        int $month,
        int $year,
        int $contract_id,
        int $credit_usage_type_id
    ){
        return CreditLimit::where('month', $month)
        ->where('year', $year)
        ->where('contract_id', $contract_id)
        ->where('credit_usage_type_id', $credit_usage_type_id)
        ->get();
    }

    public function update(
        int $credit_limit_id,
        array $data
    ){
        $credit_limit = CreditLimit::find($credit_limit_id);
        if(!$credit_limit){
            throw new \Exception("Limite de crédito não encontrado!", 404);
        }
        return $credit_limit->update($data);
    }

    public function getCreditLimit(
        int $month,
        int $year,
        int $contract_id,
        int $credit_usage_type_id,
        int $credit_modality_id
    ): ?CreditLimit{
        return CreditLimit::where('month', $month)
        ->where('year', $year)
        ->where('contract_id', $contract_id)
        ->where('credit_usage_type_id', $credit_usage_type_id)
        ->where('credit_modality_id', $credit_modality_id)
        ->where('active', true)
        ->first();
    }
}