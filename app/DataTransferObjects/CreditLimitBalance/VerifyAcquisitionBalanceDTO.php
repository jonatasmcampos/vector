<?php

namespace App\DataTransferObjects\CreditLimitBalance;

class VerifyAcquisitionBalanceDTO
{
    private int $total_amount;
    private int $current_acquisition_balance;

    public function __construct(
        int $total_amount,
        int $current_acquisition_balance
    ) {
        $this->total_amount  = $total_amount;
        $this->current_acquisition_balance  = $current_acquisition_balance;
    }

    public function getTotalAmount(): int
    {
        return $this->total_amount;
    }

    public function getCurrentAcquisitionBalance(): int{
        return $this->current_acquisition_balance;
    }

}
