<?php

namespace App\DataTransferObjects\TotalMonthlyInstallment;

class TotalMonthlyInstallmentManagementValuesDTO
{
    private readonly int $installment_id;
    private readonly int $contract_id;
    private readonly int $month;
    private readonly int $year;

    private readonly int $old_gross_amount;
    private readonly int $new_gross_amount;

    private readonly int $old_amount_paid;
    private readonly int $new_amount_paid;

    private readonly int $installment_amount;
    private readonly int $paid_amount;

    public function __construct(
        int $installment_id,
        int $contract_id,
        int $month,
        int $year,
        int $old_gross_amount,
        int $new_gross_amount,
        int $old_amount_paid,
        int $new_amount_paid,
        int $installment_amount,
        int $paid_amount
    ) {
        $this->installment_id = $installment_id;
        $this->contract_id = $contract_id;
        $this->month = $month;
        $this->year = $year;
        $this->old_gross_amount = $old_gross_amount;
        $this->new_gross_amount = $new_gross_amount;
        $this->old_amount_paid = $old_amount_paid;
        $this->new_amount_paid = $new_amount_paid;
        $this->installment_amount = $installment_amount;
        $this->paid_amount = $paid_amount;
    }

    public function getInstallmentAmount(): int{
        return $this->installment_amount;
    }

    public function getPaidAmount(): int{
        return $this->paid_amount;
    }

    public function getInstallmentId(): int
    {
        return $this->installment_id;
    }

    public function getContractId(): int
    {
        return $this->contract_id;
    }

    public function getMonth(): int
    {
        return $this->month;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getOldGrossAmount(): int
    {
        return $this->old_gross_amount;
    }

    public function getNewGrossAmount(): int
    {
        return $this->new_gross_amount;
    }

    public function getOldAmountPaid(): int
    {
        return $this->old_amount_paid;
    }

    public function getNewAmountPaid(): int
    {
        return $this->new_amount_paid;
    }
}
