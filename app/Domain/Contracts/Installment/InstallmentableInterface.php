<?php

namespace App\Domain\Contracts\Installment;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface InstallmentableInterface{
    public function installments(): MorphMany;
    public function getContractId(): int;
}