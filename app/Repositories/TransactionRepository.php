<?php

namespace App\Repositories;

use App\Models\Transaction;
use Carbon\Carbon;

class TransactionRepository{
    
    public function create(
        int $amount,
        int $transaction_type_id,
        Carbon $date,
        int $user_id,
        int $contract_id,
        int $credit_limit_id,
        ?int $installment_id = null,
        string $transaction_entity_type,
        int $transaction_entity_id,
        string $balance_history_type,
        int $balance_history_id
    ): Transaction{
        return Transaction::create([
            'amount'                    => $amount,
            'transaction_type_id'       => $transaction_type_id,
            'date'                      => $date,
            'user_id'                   => $user_id,
            'contract_id'               => $contract_id,
            'credit_limit_id'           => $credit_limit_id,
            'installment_id'            => $installment_id,
            'transaction_entity_type'   => $transaction_entity_type,
            'transaction_entity_id'     => $transaction_entity_id,
            'balance_history_type'      => $balance_history_type,
            'balance_history_id'        => $balance_history_id
        ]);
    }
}