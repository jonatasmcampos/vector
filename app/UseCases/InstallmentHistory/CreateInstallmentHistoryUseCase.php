<?php

namespace App\UseCases\InstallmentHistory;

use App\DataTransferObjects\InstallmentHistory\CreateInstallmentHistoryDTO;
use App\Repositories\InstallmentHistoryRepository;
use Illuminate\Database\Eloquent\Collection;

class CreateInstallmentHistoryUseCase{

    private InstallmentHistoryRepository $installment_history_repository;

    public function __construct(
        InstallmentHistoryRepository $installment_history_repository
    ){
        $this->installment_history_repository = $installment_history_repository;
    }

    public function handle(CreateInstallmentHistoryDTO $create_installment_history_dto){
        return $this->createInstallmentHistories(
            $create_installment_history_dto->getInstallments(),
            $create_installment_history_dto->getHistoryId()
        );
    }

    private function createInstallmentHistories(
        Collection $installments,
        int $history_id
    ){
        foreach ($installments as $key => $installment) {
            $this->installment_history_repository->create(
                $history_id,
                $installment->installment_amount,
                $installment->due_day,
                $installment->order,
                $installment->paid_at,
                $installment->amount_paid,
                $installment->external_identifier,
                $installment->installment_amount_type_id,
                $installment->installment_type_id,
                $installment->id,
                $installment->contract_id
            );
        }
    }
}