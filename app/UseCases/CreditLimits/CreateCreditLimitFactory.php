<?php

namespace App\UseCases\CreditLimits;

use App\Domain\Contracts\CreditLimits\CreateCreditLimitInterface;
use RuntimeException;

class CreateCreditLimitFactory
{
    /** @var CreateCreditLimitInterface[] */
    private array $strategies;

    public function __construct(array $strategies)
    {
        $this->strategies = $strategies;
    }

    public function make(int $credit_period_type_id): CreateCreditLimitInterface
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($credit_period_type_id)) {
                return $strategy;
            }
        }

        throw new RuntimeException("Nenhuma estratégia encontrada para o tipo: {$credit_period_type_id}");
    }
}
