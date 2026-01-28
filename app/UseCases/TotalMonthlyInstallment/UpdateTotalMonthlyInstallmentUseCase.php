<?php

namespace App\UseCases\TotalMonthlyInstallment;

use App\DataTransferObjects\TotalMonthlyInstallment\UpdateTotalMonthlyInstallmentDTO;
use App\Repositories\TotalMonthlyInstallmentRepository;

class UpdateTotalMonthlyInstallmentUseCase{

    private TotalMonthlyInstallmentRepository $total_monthly_installment_repository;

    public function __construct(
        TotalMonthlyInstallmentRepository $total_monthly_installment_repository
    ){
        $this->total_monthly_installment_repository = $total_monthly_installment_repository;
    }

    public function handle(
        UpdateTotalMonthlyInstallmentDTO $update_total_monthly_installment_dto
    ){
        return $this->update(
            $update_total_monthly_installment_dto->getTotalMonthlyInstallmentId(),
            $update_total_monthly_installment_dto->getGrossAmount(),
            $update_total_monthly_installment_dto->getPaidAmount()
        );
    }

    private function update(
        int $total_monthly_installment_id,
        ?int $gross_amount,
        ?int $paid_amount
    ){
        return $this->total_monthly_installment_repository->updateById(
            $total_monthly_installment_id,
            $this->getDataToUpdate($gross_amount, $paid_amount)
        );
    }

    private function getDataToUpdate(
        ?int $gross_amount,
        ?int $paid_amount
    ): array {
        return array_filter(
            [
                'gross_amount' => $gross_amount,
                'paid_amount'  => $paid_amount,
            ],
            fn ($value) => $value !== null
        );
    }
    
}