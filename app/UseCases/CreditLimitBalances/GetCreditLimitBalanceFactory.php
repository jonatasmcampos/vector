<?php

namespace App\UseCases\CreditLimitBalances;

use App\Domain\Contracts\CreditLimitBalance\GetCreditLimitBalanceInterface;
use RuntimeException;

class GetCreditLimitBalanceFactory
{
    /** @var GetCreditLimitBalanceInterface[] */
    private array $strategies;

    public function __construct(array $strategies)
    {
        $this->strategies = $strategies;
    }

    public function make(int $credit_period_type_id): GetCreditLimitBalanceInterface
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($credit_period_type_id)) {
                return $strategy;
            }
        }

        throw new RuntimeException("Nenhuma estratégia encontrada para o tipo: {$credit_period_type_id}");
    }
}
