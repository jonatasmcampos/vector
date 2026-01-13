<?php

namespace App\UseCases\CreditLimitBalances;

use App\Domain\Contracts\CreditLimitBalance\UpdateCreditLimitBalanceInterface;
use RuntimeException;

class UpdateCreditLimitBalanceFactory{
    /** @var UpdateCreditLimitBalanceInterface[] */
    private array $strategies;

    public function __construct(array $strategies)
    {
        $this->strategies = $strategies;
    }

    public function make(int $credit_period_type_id): UpdateCreditLimitBalanceInterface
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($credit_period_type_id)) {
                return $strategy;
            }
        }

        throw new RuntimeException("Nenhuma estratégia encontrada para o tipo: {$credit_period_type_id}");
    }
}