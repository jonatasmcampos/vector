<?php

namespace App\DataTransferObjects\TotalMonthlyInstallment;

use App\Models\Installment;
use Illuminate\Database\Eloquent\Collection;

class ManageTotalMonthlyInstallmentAcquisitionDTO{

    /** @var Collection<int, Installment> */
    private Collection $installments;

    public function __construct(
        Collection $installments
    ){
        $this->installments = $installments;
    }

    /** @return Collection<int, Installment> */
    public function getInstallments(): Collection{
        return $this->installments;
    }
    
}