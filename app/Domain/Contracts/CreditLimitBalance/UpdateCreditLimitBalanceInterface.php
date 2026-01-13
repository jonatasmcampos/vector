<?php

namespace App\Domain\Contracts\CreditLimitBalance;

use App\DataTransferObjects\CreditLimitBalance\UpdateCreditLimitBalanceDTO;
use App\Domain\ValueObjects\CreditLimitBalanceHistorySnapshot;

interface UpdateCreditLimitBalanceInterface{
    public function supports(int $credit_period_type_id): bool;
    public function execute(UpdateCreditLimitBalanceDTO $get_credit_limit_balance_dto): CreditLimitBalanceHistorySnapshot;
}