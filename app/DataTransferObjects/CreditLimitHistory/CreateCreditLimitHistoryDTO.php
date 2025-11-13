<?php

namespace App\DataTransferObjects\CreditLimitHistory;

use App\Domain\ValueObjects\AmountInCents;
use Carbon\Carbon;

class CreateCreditLimitHistoryDTO {
    
    private AmountInCents $authorized_amount;
    private AmountInCents $old_authorized_amount;
    private AmountInCents $new_authorized_amount;
    private Carbon $date;
    private int $credit_limit_id;
    private int $history_id;
    private int $contract_id;
    private int $credit_usage_type_id;
    private int $credit_modality_id;
    private int $credit_period_type_id;

    public function __construct(
        AmountInCents $authorized_amount,
        AmountInCents $old_authorized_amount,
        AmountInCents $new_authorized_amount,
        Carbon $date,
        int $credit_limit_id,
        int $history_id,
        int $contract_id,
        int $credit_usage_type_id,
        int $credit_modality_id,
        int $credit_period_type_id
    ){
        $this->authorized_amount = $authorized_amount;
        $this->old_authorized_amount = $old_authorized_amount;
        $this->new_authorized_amount = $new_authorized_amount;
        $this->date = $date;
        $this->credit_limit_id = $credit_limit_id;
        $this->history_id = $history_id;
        $this->contract_id = $contract_id;
        $this->credit_usage_type_id = $credit_usage_type_id;
        $this->credit_modality_id = $credit_modality_id;
        $this->credit_period_type_id = $credit_period_type_id;
    }


    public function getAuthorizedAmount(): AmountInCents
    {
        return $this->authorized_amount;
    }

    public function getOldAuthorizedAmount(): AmountInCents
    {
        return $this->old_authorized_amount;
    }

    public function getNewAuthorizedAmount(): AmountInCents
    {
        return $this->new_authorized_amount;
    }

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function getCreditLimitId(): int
    {
        return $this->credit_limit_id;
    }

    public function getHistoryId(): int
    {
        return $this->history_id;
    }

    public function getContractId(): int
    {
        return $this->contract_id;
    }

    public function getCreditUsageTypeId(): int
    {
        return $this->credit_usage_type_id;
    }

    public function getCreditModalityId(): int
    {
        return $this->credit_modality_id;
    }

    public function getCreditPeriodTypeId(): int
    {
        return $this->credit_period_type_id;
    }
}