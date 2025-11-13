<?php 

namespace App\Repositories;

use App\Models\CreditLimitBalanceHistory;
use Carbon\Carbon;

class CreditLimitBalanceHistoryRepository{
    public function create(
        Carbon $date,
        int $used_amount,
        int $old_used_amount,
        int $new_used_amount,
        int $old_balance,
        int $new_balance,
        int $credit_limit_balance_id,
        int $history_id,
        int $contract_id
    ): CreditLimitBalanceHistory{
        return CreditLimitBalanceHistory::create([
            'date' => $date,
            'used_amount' => $used_amount,
            'old_used_amount' => $old_used_amount,
            'new_used_amount' => $new_used_amount,
            'old_balance' => $old_balance,
            'new_balance' => $new_balance,
            'credit_limit_balance_id' => $credit_limit_balance_id,
            'history_id' => $history_id,
            'contract_id' => $contract_id
        ]);
    }
}