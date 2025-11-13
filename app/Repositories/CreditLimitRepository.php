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

    public function getByMonthYearAndContractId(
        int $month,
        int $year,
        int $contract_id
    ){
        return CreditLimit::where('month', $month)
        ->where('year', $year)
        ->where('contract_id', $contract_id)
        ->get();
    }
}