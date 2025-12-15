<?php

namespace App\Repositories;

use App\Models\TotalMonthlyInstallmentHistory;

class TotalMonthlyInstallmentHistoryRepository{
    public function create(
        int $history_id,
        int $installment_id,
        int $total_monthly_installment_id,
        int $gross_amount,
        int $old_gross_amount,
        int $new_gross_amount,
        int $amount_paid,
        int $old_amount_paid,
        int $new_amount_paid,
		int $month,
        int $year,
        int $contract_id
    ): TotalMonthlyInstallmentHistory{
        return TotalMonthlyInstallmentHistory::create([
            'history_id' => $history_id,
            'installment_id' => $installment_id,
            'total_monthly_installment_id' => $total_monthly_installment_id,
            'gross_amount' => $gross_amount,
            'old_gross_amount' => $old_gross_amount,
            'new_gross_amount' => $new_gross_amount,
            'amount_paid' => $amount_paid,
            'old_amount_paid' => $old_amount_paid,
            'new_amount_paid' => $new_amount_paid,
		    'month' => $month,
            'year' => $year,
            'contract_id' => $contract_id
        ]);
    }
}