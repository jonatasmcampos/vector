<?php

namespace App\Repositories;

use App\Models\CreditLimitBalance;

class CreditLimitBalanceRepository {
    public function create(
        int $total_used_amount,
        int $balance,
        int $contract_id,
        int $credit_limit_id,
    ): CreditLimitBalance{
        return CreditLimitBalance::create([
            'total_used_amount' => $total_used_amount,
            'balance' => $balance,
            'contract_id' => $contract_id,
            'credit_limit_id' => $credit_limit_id,
            'active' => true
        ]);
    }
}