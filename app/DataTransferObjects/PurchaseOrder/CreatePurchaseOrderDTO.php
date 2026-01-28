<?php

namespace App\DataTransferObjects\PurchaseOrder;

use App\Domain\ValueObjects\CreditLimitBalanceSnapshot;

class CreatePurchaseOrderDTO {
    private array $header;
    private array $purchase_order_data;
    private array $materials;
    private array $installments;
    private CreditLimitBalanceSnapshot $acquisition_credit_limit_balance_snapshot;
    private CreditLimitBalanceSnapshot $payment_credit_limit_balance_snapshot;

    public function __construct(
        array $header,
        array $purchase_order_data,
        array $materials,
        array $installments,
        CreditLimitBalanceSnapshot $acquisition_credit_limit_balance_snapshot,
        CreditLimitBalanceSnapshot $payment_credit_limit_balance_snapshot
    ) {
        $this->header                                     = $header;
        $this->purchase_order_data                        = $purchase_order_data;
        $this->materials                                  = $materials;
        $this->installments                               = $installments;
        $this->acquisition_credit_limit_balance_snapshot  = $acquisition_credit_limit_balance_snapshot;
        $this->payment_credit_limit_balance_snapshot      = $payment_credit_limit_balance_snapshot;
    }

    public function getHeader(): array
    {
        return $this->header;
    }

    public function getPurchaseOrderData(): array
    {
        return $this->purchase_order_data;
    }

    public function getMaterials(): array
    {
        return $this->materials;
    }

    public function getInstallments(): array
    {
        return $this->installments;
    }

    public function getAcquisitionCreditLimitBalanceSnapshot(): CreditLimitBalanceSnapshot{
        return $this->acquisition_credit_limit_balance_snapshot;
    }

    public function getPaymentCreditLimitBalanceSnapshot(): CreditLimitBalanceSnapshot{
        return $this->payment_credit_limit_balance_snapshot;
    }
}