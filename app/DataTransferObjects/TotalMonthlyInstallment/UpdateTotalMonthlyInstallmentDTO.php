<?php

namespace App\DataTransferObjects\TotalMonthlyInstallment;

class UpdateTotalMonthlyInstallmentDTO{

    private int $total_monthly_installment_id;
    private ?int $gross_amount;
    private ?int $paid_amount;

    public function __construct(
        int $total_monthly_installment_id,
        ?int $gross_amount,
        ?int $paid_amount
    ){
        $this->total_monthly_installment_id = $total_monthly_installment_id;
        $this->gross_amount = $gross_amount;
        $this->paid_amount = $paid_amount;
    }

    public function getTotalMonthlyInstallmentId(): int{
        return $this->total_monthly_installment_id;
    }

    public function getGrossAmount(): ?int{
        return $this->gross_amount;
    }

    public function getPaidAmount(): ?int{
        return $this->paid_amount;
    }

}