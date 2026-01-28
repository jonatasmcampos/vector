<?php

namespace App\Domain\Contracts\CreditLimitBalance;

use App\DataTransferObjects\CreditLimitBalance\GetCreditLimitBalanceDTO;
use App\Domain\ValueObjects\CreditLimitBalanceSnapshot;

interface GetCreditLimitBalanceInterface{
    public function supports(int $credit_period_type_id): bool;
    public function execute(GetCreditLimitBalanceDTO $get_credit_limit_balance_dto): CreditLimitBalanceSnapshot;
}