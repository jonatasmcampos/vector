<?php

namespace App\DataTransferObjects\TotalMonthlyInstallment;

class CreateTotalMonthlyInstallmentDTO{

    private ?int $gross_amount;
    private ?int $paid_amount;
	private int $month;
    private int $year;
    private int $contract_id;

    public function __construct(
        ?int $gross_amount,
        ?int $paid_amount,
        int $month,
        int $year,
        int $contract_id
    ){
        $this->gross_amount = $gross_amount;
        $this->paid_amount = $paid_amount;
        $this->month = $month;
        $this->year = $year;
        $this->contract_id = $contract_id;
    }

    public function getGrossAmount(): ?int{
        return $this->gross_amount;
    }

    public function getPaidAmount(): ?int{
        return $this->paid_amount;
    }

    public function getMonth(): int{
        return $this->month;
    }

    public function getYear(): int{
        return $this->year;
    }

    public function getContractId(): int{
        return $this->contract_id;
    }
    
}