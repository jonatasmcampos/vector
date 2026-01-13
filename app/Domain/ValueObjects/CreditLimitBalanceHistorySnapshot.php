<?php

namespace App\Domain\ValueObjects;

final class CreditLimitBalanceHistorySnapshot{
    public function __construct(
        public readonly int $credit_limit_balance_history_id,
        public readonly string $credit_limit_balance_history_type,
        public readonly int $credit_period_type_id,
        public readonly int $credit_modality_id,
    ){}
}