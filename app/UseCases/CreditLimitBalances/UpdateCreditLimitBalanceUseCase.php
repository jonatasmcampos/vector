<?php

namespace App\UseCases\CreditLimitBalances;

use App\DataTransferObjects\CreditLimitBalance\UpdateCreditLimitBalanceDTO;
use App\Domain\ValueObjects\CreditLimitBalanceHistorySnapshot;

class UpdateCreditLimitBalanceUseCase{
    
    private UpdateCreditLimitBalanceFactory $update_credit_limit_balance_factory;

    public function __construct(
        UpdateCreditLimitBalanceFactory $update_credit_limit_balance_factory
    ){
        $this->update_credit_limit_balance_factory = $update_credit_limit_balance_factory;
    }

    public function handle(UpdateCreditLimitBalanceDTO $dto): CreditLimitBalanceHistorySnapshot{
        $strategy = $this->update_credit_limit_balance_factory->make($dto->getCreditPeriodTypeId());
        return $strategy->execute($dto);
    }

}