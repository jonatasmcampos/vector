<?php

namespace App\UseCases\TotalMonthlyInstallmentHistory;

use App\DataTransferObjects\TotalMonthlyInstallmentHistory\CreateTotalMonthlyInstallmentHistoryDTO;
use App\DataTransferObjects\TotalMonthlyInstallment\TotalMonthlyInstallmentManagementValuesDTO;
use App\Repositories\TotalMonthlyInstallmentHistoryRepository;
use App\Repositories\TotalMonthlyInstallmentRepository;

class CreateTotalMonthlyInstallmentHistoryUseCase
{
    private TotalMonthlyInstallmentHistoryRepository $history_repository;
    private TotalMonthlyInstallmentRepository $total_monthly_installment_repository;

    public function __construct(
        TotalMonthlyInstallmentHistoryRepository $history_repository,
        TotalMonthlyInstallmentRepository $total_monthly_installment_repository
    ) {
        $this->history_repository = $history_repository;
        $this->total_monthly_installment_repository = $total_monthly_installment_repository;
    }

    public function handle(
        CreateTotalMonthlyInstallmentHistoryDTO $dto
    ): void {
        $this->create(
            $dto->getHistoryId(),
            $dto->getManagementValues()
        );
    }

    /**
     * @param TotalMonthlyInstallmentManagementValuesDTO[] $changes
     */
    private function create(
        int $history_id,
        array $changes
    ): void {
        foreach ($changes as $change) {
            $total_monthly_installment = $this->getTotalMonthlyInstallment(
                $change->getMonth(),
                $change->getYear(),
                $change->getContractId()
            );
            $this->history_repository->create(
                history_id: $history_id,
                installment_id: $change->getInstallmentId(),
                total_monthly_installment_id: $total_monthly_installment->id,
                gross_amount: $change->getInstallmentAmount(),
                old_gross_amount: $change->getOldGrossAmount(),
                new_gross_amount: $change->getNewGrossAmount(),
                amount_paid: $change->getPaidAmount(),
                old_amount_paid: $change->getOldAmountPaid(),
                new_amount_paid: $change->getNewAmountPaid(),
                month: $change->getMonth(),
                year: $change->getYear(),
                contract_id: $change->getContractId()
            );
        }
    }

    private function getTotalMonthlyInstallment(
        int $month,
        int $year,
        int $contract_id
    ) {
        return $this->total_monthly_installment_repository
            ->getByMonthAndYearAndContractId(
                $month,
                $year,
                $contract_id
            );
    }
}
