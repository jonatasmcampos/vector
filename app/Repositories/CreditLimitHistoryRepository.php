<?php 

namespace App\Repositories;

use App\Models\CreditLimitHistory;
use Carbon\Carbon;

class CreditLimitHistoryRepository{
    public function create(
        int $authorized_amount,
        int $old_authorized_amount,
        int $new_authorized_amount,
        Carbon $date,
        int $credit_limit_id,
        int $history_id,
        int $contract_id,
        int $credit_usage_type_id,
        int $credit_modality_id,
        int $credit_period_type_id
    ): CreditLimitHistory{
        return CreditLimitHistory::create([
            'authorized_amount' => $authorized_amount,
            'old_authorized_amount' => $old_authorized_amount,
            'new_authorized_amount' => $new_authorized_amount,
            'date' => $date,
            'credit_limit_id' => $credit_limit_id,
            'history_id' => $history_id,
            'contract_id' => $contract_id,
            'credit_usage_type_id' => $credit_usage_type_id,
            'credit_modality_id' => $credit_modality_id,
            'credit_period_type_id' => $credit_period_type_id
        ]);
    }
}