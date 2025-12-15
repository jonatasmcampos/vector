<?php

namespace App\Repositories;

use App\Models\InstallmentHistory;
use Carbon\Carbon;

class InstallmentHistoryRepository{
    public function create(
        int $history_id,
        int $installment_amount,
        Carbon $due_day,
        int $order,
        ?int $paid_at = null,
        ?int $amount_paid = null,
        int $external_identifier,
        int $installment_amount_type_id,
        int $installment_type_id,
        int $installment_id,
        int $contract_id
    ): InstallmentHistory{
        return InstallmentHistory::create([
            'history_id' => $history_id,
            'installment_amount' => $installment_amount,
            'due_day' => $due_day,
            'order' => $order,
            'paid_at' => $paid_at,
            'amount_paid' => $amount_paid,
            'external_identifier' => $external_identifier,
            'installment_amount_type_id' => $installment_amount_type_id,
            'installment_type_id' => $installment_type_id,
            'installment_id' => $installment_id,
            'contract_id' => $contract_id
        ]);
    }
}