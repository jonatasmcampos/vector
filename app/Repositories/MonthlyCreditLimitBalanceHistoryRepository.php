<?php 

namespace App\Repositories;

use App\Models\MonthlyCreditLimitBalanceHistory;
use Carbon\Carbon;

class MonthlyCreditLimitBalanceHistoryRepository{
    public function create(
        Carbon $date,
        int $used_amount,
        int $old_used_amount,
        int $new_used_amount,
        int $old_balance,
        int $new_balance,
        int $monthly_credit_limit_balance_id,
        int $history_id,
        int $contract_id
    ): MonthlyCreditLimitBalanceHistory{
        return MonthlyCreditLimitBalanceHistory::create([
            'date' => $date,
            'used_amount' => $used_amount,
            'old_used_amount' => $old_used_amount,
            'new_used_amount' => $new_used_amount,
            'old_balance' => $old_balance,
            'new_balance' => $new_balance,
            'monthly_credit_limit_balance_id' => $monthly_credit_limit_balance_id,
            'history_id' => $history_id,
            'contract_id' => $contract_id
        ]);
    }
}