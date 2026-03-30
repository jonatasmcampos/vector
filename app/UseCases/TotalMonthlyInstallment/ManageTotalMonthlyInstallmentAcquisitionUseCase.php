<?php

namespace App\UseCases\TotalMonthlyInstallment;

use App\DataTransferObjects\TotalMonthlyInstallment\CreateTotalMonthlyInstallmentDTO;
use App\DataTransferObjects\TotalMonthlyInstallment\ManageTotalMonthlyInstallmentAcquisitionDTO;
use App\DataTransferObjects\TotalMonthlyInstallment\TotalMonthlyInstallmentManagementValuesDTO;
use App\DataTransferObjects\TotalMonthlyInstallment\UpdateTotalMonthlyInstallmentDTO;
use App\Domain\ValueObjects\Date;
use App\Models\TotalMonthlyInstallment;
use App\Repositories\TotalMonthlyInstallmentRepository;

class ManageTotalMonthlyInstallmentAcquisitionUseCase
{
    private CreateTotalMonthlyInstallmentUseCase $create_total_monthly_installment_use_case;
    private UpdateTotalMonthlyInstallmentUseCase $update_total_monthly_installment_use_case;
    private TotalMonthlyInstallmentRepository $total_monthly_installment_repository;

    public function __construct(
        CreateTotalMonthlyInstallmentUseCase $create_total_monthly_installment_use_case,
        UpdateTotalMonthlyInstallmentUseCase $update_total_monthly_installment_use_case,
        TotalMonthlyInstallmentRepository $total_monthly_installment_repository
    ) {
        $this->create_total_monthly_installment_use_case = $create_total_monthly_installment_use_case;
        $this->update_total_monthly_installment_use_case = $update_total_monthly_installment_use_case;
        $this->total_monthly_installment_repository = $total_monthly_installment_repository;
    }

    /**
     * @return TotalMonthlyInstallmentManagementValuesDTO[]
     */
    public function handle(
        ManageTotalMonthlyInstallmentAcquisitionDTO $dto
    ): array {
        return $this->manage($dto);
    }

    /**
     * @return TotalMonthlyInstallmentManagementValuesDTO[]
     */
    private function manage(
        ManageTotalMonthlyInstallmentAcquisitionDTO $dto
    ): array {
        $installments = $dto->getInstallments();
        $changes = [];

        foreach ($installments as $installment) {
            $contract_id = $installment->contract_id;
            $year  = Date::fromCarbon($installment->due_day)->format('Y');
            $month = Date::fromCarbon($installment->due_day)->format('m');

            $current = $this->getTotalMonthlyInstallment(
                $month,
                $year,
                $contract_id
            );

            $old_gross_amount = $current?->gross_amount ?? 0;
            $old_amount_paid  = $current?->amount_paid ?? 0;

            $new_gross_amount = $old_gross_amount + $installment->installment_amount;
            $new_amount_paid  = $old_amount_paid;

            if (!$current) {
                $this->createTotalMonthlyInstallment(
                    $installment->installment_amount,
                    0,
                    $month,
                    $year,
                    $contract_id
                );
            } else {
                $this->updateTotalMonthlyInstallment(
                    $current->id,
                    $new_gross_amount,
                    null
                );
            }

            $changes[] = new TotalMonthlyInstallmentManagementValuesDTO(
                $installment->id,
                $contract_id,
                $month,
                $year,
                $old_gross_amount,
                $new_gross_amount,
                $old_amount_paid,
                $new_amount_paid,
                $installment->installment_amount,
                0
            );
        }

        return $changes;
    }

    private function createTotalMonthlyInstallment(
        int $gross_amount,
        int $paid_amount,
        int $month,
        int $year,
        int $contract_id
    ): TotalMonthlyInstallment {
        return $this->create_total_monthly_installment_use_case->handle(
            new CreateTotalMonthlyInstallmentDTO(
                $gross_amount,
                $paid_amount,
                $month,
                $year,
                $contract_id
            )
        );
    }

    private function updateTotalMonthlyInstallment(
        int $total_monthly_installment_id,
        ?int $gross_amount = null,
        ?int $paid_amount = null
    ) {
        return $this->update_total_monthly_installment_use_case->handle(
            new UpdateTotalMonthlyInstallmentDTO(
                $total_monthly_installment_id,
                $gross_amount,
                $paid_amount
            )
        );
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
