<?php

namespace App\Domain\Contracts\BillableResource;

use App\Domain\ValueObjects\Date;

interface BillableResourceInterface{
    public function getActionDate(): Date;
    public function getContractId(): int;
    public function getTotalAmount(): int;
    public function getInstallments(): array;
    public function execute(): void;
}