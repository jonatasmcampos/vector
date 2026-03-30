<?php

namespace App\DataTransferObjects\CreditLimitBalance;

use App\Domain\ValueObjects\CreditLimitBalanceSnapshot;

class UpdateCreditLimitBalanceDTO{
    private int $credit_limit_balance_id;
    private int $credit_limit_id;
    private int $credit_period_type_id;
    private int $contract_id;
    private int $credit_usage_type_id;
    private int $credit_modality_id;
    private int $used_amount;
    private CreditLimitBalanceSnapshot $acquisition_credit_limit_balance_snapshot;
    private CreditLimitBalanceSnapshot $payment_credit_limit_balance_snapshot;
    private int $user_id;

    public function __construct(
        int $credit_limit_balance_id,
        int $credit_limit_id,
        int $credit_period_type_id,
        int $contract_id,
        int $credit_usage_type_id,
        int $credit_modality_id,
        int $used_amount,
        CreditLimitBalanceSnapshot $acquisition_credit_limit_balance_snapshot,
        CreditLimitBalanceSnapshot $payment_credit_limit_balance_snapshot,
        int $user_id
    ){
        $this->credit_limit_balance_id = $credit_limit_balance_id;
        $this->credit_limit_id = $credit_limit_id;
        $this->credit_period_type_id = $credit_period_type_id;
        $this->contract_id = $contract_id;
        $this->contract_id = $contract_id;
        $this->credit_usage_type_id = $credit_usage_type_id;
        $this->credit_modality_id = $credit_modality_id;
        $this->credit_period_type_id = $credit_period_type_id;
        $this->used_amount = $used_amount;
        $this->credit_limit_balance_id = $credit_limit_balance_id;
        $this->credit_limit_id = $credit_limit_id;
        $this->acquisition_credit_limit_balance_snapshot = $acquisition_credit_limit_balance_snapshot;
        $this->payment_credit_limit_balance_snapshot = $payment_credit_limit_balance_snapshot;
        $this->user_id = $user_id;
    }

    public function getCreditLimitBalanceId(): int{
        return $this->credit_limit_balance_id;
    }
    public function getCreditLimitId(): int{
        return $this->credit_limit_id;
    }
    public function getCreditPeriodTypeId(): int{
        return $this->credit_period_type_id;
    }
    public function getContractId(): int{
        return $this->contract_id;
    }
    public function getCreditUsageTypeId(): int{
        return $this->credit_usage_type_id;
    }
    public function getCreditModalityId(): int{
        return $this->credit_modality_id;
    }
    public function getUsedAmount(): int{
        return $this->used_amount;
    }
    public function getAcquisitionCreditLimitBalanceSnapshot(): CreditLimitBalanceSnapshot{
        return $this->acquisition_credit_limit_balance_snapshot;
    }
    public function getPaymentCreditLimitBalanceSnapshot(): CreditLimitBalanceSnapshot{
        return $this->payment_credit_limit_balance_snapshot;
    }
    public function getUserId(): int{
        return $this->user_id;
    }

}