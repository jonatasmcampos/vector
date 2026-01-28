<?php

namespace App\Domain\ValueObjects;

use App\Enums\CreditModalityEnum;

final class CreditLimitBalanceSnapshot{
    public function __construct(
        public readonly int $credit_limit_balance_id,
        public readonly int $credit_period_type_id,
        public readonly int $balance,
        public readonly int $total_used_amount,
        public readonly int $contract_id,
        public readonly int $credit_limit_id
    ){}
}