<?php 

namespace App\DataTransferObjects\Transaction;

class GetTransactionListViewDTO{
    public function __construct(
        public string $icon,
        public string $text_class,
        public string $datetime,
        public string $user,
        public string $transaction_type,
        public string $contract,
        public string $transaction_entity,
        public string $payment_nature,
        public string $payment_method,
        public int    $installments_number,
        public string $amount,
        public string $old_balance,
        public string $new_balance,
    ) {}
}