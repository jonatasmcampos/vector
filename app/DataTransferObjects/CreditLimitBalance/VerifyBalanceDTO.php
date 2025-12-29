<?php

namespace App\DataTransferObjects\CreditLimitBalance;

use App\Domain\ValueObjects\Date;

class VerifyBalanceDTO
{
    private Date $action_date;
    private int $contract_id;
    private int $total_amount;
    private array $installments;

    public function __construct(
        Date $action_date,
        int $contract_id,
        int $total_amount,
        array $installments
    ) {
        $this->action_date   = $action_date;
        $this->contract_id   = $contract_id;
        $this->total_amount  = $total_amount;
        $this->installments  = $installments;
    }

    public function getActionDate(): Date
    {
        return $this->action_date;
    }

    public function getContractId(): int
    {
        return $this->contract_id;
    }

    public function getTotalAmount(): int
    {
        return $this->total_amount;
    }

    public function getInstallments(): array
    {
        return $this->installments;
    }
}
