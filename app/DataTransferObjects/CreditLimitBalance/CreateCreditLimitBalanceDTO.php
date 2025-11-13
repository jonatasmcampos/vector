<?php

namespace App\DataTransferObjects\CreditLimitBalance;

use App\Domain\ValueObjects\AmountInCents;

class CreateCreditLimitBalanceDTO {
    
    private AmountInCents $total_used_amount;
    private AmountInCents $balance;
    private int $contract_id;
    private int $credit_limit_id;

    public function __construct(
        AmountInCents $total_used_amount,
        AmountInCents $balance,
        int $contract_id,
        int $credit_limit_id
    ){
        $this->total_used_amount = $total_used_amount;
        $this->balance = $balance;
        $this->contract_id = $contract_id;
        $this->credit_limit_id = $credit_limit_id;
    }

    public function getContractId(): int{
        return $this->contract_id;
    }

    public function getTotalUsedAmount(): AmountInCents{
        return $this->total_used_amount;
    }

    public function getBalance(): AmountInCents{
        return $this->balance;
    }
    
    public function getCreditLimitId(): int
    {
        return $this->credit_limit_id;
    }

}