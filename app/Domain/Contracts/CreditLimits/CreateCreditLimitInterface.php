<?php

namespace App\Domain\Contracts\CreditLimits;

use App\DataTransferObjects\CreditLimits\CreateCreditLimitDTO;

interface CreateCreditLimitInterface{
    public function supports(int $credit_period_type_id): bool;
    public function execute(CreateCreditLimitDTO $dto): void;
}