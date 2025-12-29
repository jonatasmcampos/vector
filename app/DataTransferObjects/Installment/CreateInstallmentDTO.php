<?php

namespace App\DataTransferObjects\Installment;

use App\Domain\Contracts\Installment\InstallmentableInterface;

class CreateInstallmentDTO{
    private InstallmentableInterface $installmentable;
    private array $installments;

    public function __construct(
        InstallmentableInterface $installmentable,
        array $installments
    ) {
        $this->installmentable = $installmentable;
        $this->installments = $installments;
    }

    public function getInstallmentable(): InstallmentableInterface
    {
        return $this->installmentable;
    }

    public function getInstallments(): array
    {
        return $this->installments;
    }
}