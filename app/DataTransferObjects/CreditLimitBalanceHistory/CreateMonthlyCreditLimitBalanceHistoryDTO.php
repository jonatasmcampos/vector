<?php

namespace App\DataTransferObjects\CreditLimitBalanceHistory;

use App\Domain\ValueObjects\AmountInCents;
use Carbon\Carbon;

class CreateMonthlyCreditLimitBalanceHistoryDTO {
    private Carbon $date;
    private AmountInCents $used_amount;
    private AmountInCents $old_used_amount;
    private AmountInCents $new_used_amount;
    private AmountInCents $old_balance;
    private AmountInCents $new_balance;
    private int $monthly_credit_limit_balance_id;
    private int $history_id;
    private int $contract_id;

    public function __construct(
        Carbon $date,
        AmountInCents $used_amount,
        AmountInCents $old_used_amount,
        AmountInCents $new_used_amount,
        AmountInCents $old_balance,
        AmountInCents $new_balance,
        int $monthly_credit_limit_balance_id,
        int $history_id,
        int $contract_id
    ){
        $this->date = $date;
        $this->used_amount = $used_amount;
        $this->old_used_amount = $old_used_amount;
        $this->new_used_amount = $new_used_amount;
        $this->old_balance = $old_balance;
        $this->new_balance = $new_balance;
        $this->monthly_credit_limit_balance_id = $monthly_credit_limit_balance_id;
        $this->history_id = $history_id;
        $this->contract_id = $contract_id;
    }

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function getUsedAmount(): AmountInCents
    {
        return $this->used_amount;
    }

    public function getOldUsedAmount(): AmountInCents
    {
        return $this->old_used_amount;
    }

    public function getNewUsedAmount(): AmountInCents
    {
        return $this->new_used_amount;
    }

    public function getOldBalance(): AmountInCents
    {
        return $this->old_balance;
    }

    public function getNewBalance(): AmountInCents
    {
        return $this->new_balance;
    }

    public function getCreditLimitBalanceId(): int
    {
        return $this->monthly_credit_limit_balance_id;
    }

    public function getHistoryId(): int
    {
        return $this->history_id;
    }

    public function getContractId(): int
    {
        return $this->contract_id;
    }
}