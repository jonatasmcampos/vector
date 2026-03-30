<?php

namespace App\DataTransferObjects\CreditLimits;

use App\Domain\ValueObjects\AmountInCents;

class CreateCreditLimitDTO {
    
    private int $contract_id;
    private AmountInCents $authorized_amount;
    private int $credit_usage_type_id;
    private int $credit_modality_id;
    private int $credit_period_type_id;
    private int $month;
    private int $user_id;

    public function __construct(
        array $request,
        int $user_id
    ){
        $this->contract_id = $request['contract_id'];
        $this->authorized_amount = AmountInCents::fromString($request['authorized_amount']);
        $this->credit_usage_type_id = $request['credit_usage_type_id'];
        $this->credit_modality_id = $request['credit_modality_id'];
        $this->credit_period_type_id = $request['credit_period_type_id'];
        $this->month = $request['month'];
        $this->user_id = $user_id;
    }

    public function getContractId(): int{
        return $this->contract_id;
    }

    public function getAuthorizedAmount(): AmountInCents{
        return $this->authorized_amount;
    }

    public function getCreditUsageTypeId(): int{
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

    public function getReferenceMonth(): int
    {
        return $this->month;
    }

    public function getUserId(): int{
        return $this->user_id;
    }
}