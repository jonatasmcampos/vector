<?php

namespace App\UseCases\TotalMonthlyInstallment;

use App\DataTransferObjects\TotalMonthlyInstallment\CreateTotalMonthlyInstallmentDTO;
use App\Models\TotalMonthlyInstallment;
use App\Repositories\TotalMonthlyInstallmentRepository;

class CreateTotalMonthlyInstallmentUseCase{

    private TotalMonthlyInstallmentRepository $total_monthly_installment_repository;

    public function __construct(
        TotalMonthlyInstallmentRepository $total_monthly_installment_repository
    ){
        $this->total_monthly_installment_repository = $total_monthly_installment_repository;
    }

    public function handle(
        CreateTotalMonthlyInstallmentDTO $create_total_monthly_installment_dto
    ): TotalMonthlyInstallment{
        return $this->create(
            $create_total_monthly_installment_dto->getGrossAmount(),
            $create_total_monthly_installment_dto->getPaidAmount() ?? 0,
            $create_total_monthly_installment_dto->getMonth(),
            $create_total_monthly_installment_dto->getYear(),
            $create_total_monthly_installment_dto->getContractId()
        );
    }

    private function create(
        int $gross_amount,
        int $paid_amount,
		int $month,
        int $year,
        int $contract_id
    ): TotalMonthlyInstallment{
        return $this->total_monthly_installment_repository->create(
            $gross_amount,
            $paid_amount,
            $month,
            $year,
            $contract_id
        );
    }

}