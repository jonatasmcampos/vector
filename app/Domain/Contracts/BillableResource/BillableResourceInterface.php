<?php

namespace App\Domain\Contracts\BillableResource;

use App\DataTransferObjects\BillableResource\TransactionsDataDTO;
use App\Domain\ValueObjects\CreditLimitBalanceSnapshot;
use App\Domain\ValueObjects\Date;

interface BillableResourceInterface{
    public function getActionDate(): Date;
    public function getContractId(): int;
    public function getTotalAmount(): int;
    public function getInstallments(): array;
    public function getCreditUsageTypeId(): int;
    public function getCreditModalityId(): int;
    public function getCreditPeriodTypeId(): int;
    public function getAcquisitionCreditLimitBalanceSnapshot(): CreditLimitBalanceSnapshot;
    public function getPaymentCreditLimitBalanceSnapshot(): CreditLimitBalanceSnapshot;
    public function execute(): TransactionsDataDTO;
}