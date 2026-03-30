<?php

namespace App\DataTransferObjects\CreditLimitBalance;

class VerifyPaymentBalanceDTO
{
    private int $total_amount;
    private array $installments;
    private int $current_payment_balance;

    public function __construct(
        int $total_amount,
        array $installments,
        int $current_payment_balance
    ) {
        $this->total_amount  = $total_amount;
        $this->installments  = $installments;
        $this->current_payment_balance  = $current_payment_balance;
    }

    public function getTotalAmount(): int
    {
        return $this->total_amount;
    }

    public function getInstallments(): array
    {
        return $this->installments;
    }

    public function getCurrentPaymentBalance(): int{
        return $this->current_payment_balance;
    }
}
