<?php

namespace App\UseCases\CreditLimitBalances;

use App\DataTransferObjects\CreditLimitBalance\UpdateCreditLimitBalanceDTO;
use App\DataTransferObjects\CreditLimitBalanceHistory\CreateMonthlyCreditLimitBalanceHistoryDTO;
use App\DataTransferObjects\Histories\CreateHistoryDTO;
use App\Domain\Contracts\CreditLimitBalance\UpdateCreditLimitBalanceInterface;
use App\Domain\ValueObjects\AmountInCents;
use App\Domain\ValueObjects\CreditLimitBalanceHistorySnapshot;
use App\Enums\ActionEnum;
use App\Enums\CreditModalityEnum;
use App\Enums\CreditPeriodTypeEnum;
use App\Enums\ProcessEnum;
use App\Repositories\MonthlyCreditLimitBalanceRepository;
use App\UseCases\CreditLimitBalanceHistories\Monthly\CreateMonthlyCreditLimitBalanceHistoryUseCase;
use App\UseCases\Histories\CreateHistoryUseCase;
use Carbon\Carbon;

class UpdateMonthlyCreditLimitBalanceStrategy implements UpdateCreditLimitBalanceInterface{

    private MonthlyCreditLimitBalanceRepository $monthly_credit_limit_balance_repository;
    private CreateHistoryUseCase $create_history_use_case;
    private CreateMonthlyCreditLimitBalanceHistoryUseCase $monthly_credit_limit_balance_history_use_case;

    public function __construct(
        MonthlyCreditLimitBalanceRepository $monthly_credit_limit_balance_repository,
        CreateHistoryUseCase $create_history_use_case,
        CreateMonthlyCreditLimitBalanceHistoryUseCase $monthly_credit_limit_balance_history_use_case
    ){
        $this->monthly_credit_limit_balance_repository = $monthly_credit_limit_balance_repository;
        $this->create_history_use_case = $create_history_use_case;
        $this->monthly_credit_limit_balance_history_use_case = $monthly_credit_limit_balance_history_use_case;
    }

    public function supports(int $credit_period_type_id): bool
    {
        return CreditPeriodTypeEnum::MONTHLY->value === $credit_period_type_id;
    }

    public function execute(UpdateCreditLimitBalanceDTO $get_credit_limit_balance_dto): CreditLimitBalanceHistorySnapshot{
        return $this->update($get_credit_limit_balance_dto);
    }

    private function update(UpdateCreditLimitBalanceDTO $get_credit_limit_balance_dto): CreditLimitBalanceHistorySnapshot{
        $data_to_update = $this->getDataToUpdate($get_credit_limit_balance_dto);
        $this->monthly_credit_limit_balance_repository->update(
            $get_credit_limit_balance_dto->getCreditLimitBalanceId(),
            $data_to_update
        );
        $balance_history = $this->saveHistory(
            $get_credit_limit_balance_dto,
            $data_to_update
        );
        return new CreditLimitBalanceHistorySnapshot(
            $balance_history->id,
            $balance_history->getMorphClass(),
            CreditPeriodTypeEnum::MONTHLY->value,
            $balance_history->monthly_credit_limit_balance->credit_limit->credit_modality_id
        );
    }

    private function getDataToUpdate(UpdateCreditLimitBalanceDTO $dto){
        $used_amount = $dto->getUsedAmount();
        $snapshot = $this->getCreditLimitBalanceSnapshotBasedOnModality($dto);
        return [
            'balance' => $snapshot->balance - $used_amount,
            'total_used_amount' => $snapshot->total_used_amount + $used_amount,
        ];
    }

    private function getCreditLimitBalanceSnapshotBasedOnModality(UpdateCreditLimitBalanceDTO $dto){
        $snapshot = match ($dto->getCreditModalityId()) {
            CreditModalityEnum::ACQUISITION->value =>
                $dto->getAcquisitionCreditLimitBalanceSnapshot(),

            CreditModalityEnum::PAYMENT->value =>
                $dto->getPaymentCreditLimitBalanceSnapshot(),

            default => throw new \InvalidArgumentException('Modalidade de crédito inválida'),
        };
        return $snapshot;
    }

    private function createHistory(
        UpdateCreditLimitBalanceDTO $dto
    ){
        return $this->create_history_use_case->handle(
            new CreateHistoryDTO(
                Carbon::now(),
                'atualizou limite de crédito',
                $dto->getUserId(),
                ActionEnum::CREDIT_LIMIT_BALANCE_UPDATED->value,
                ProcessEnum::EXTERNAL_PURCHASE_ORDER_CREATION->value,
                $dto->getContractId(),
            )
        );
    }

    private function saveHistory(
        UpdateCreditLimitBalanceDTO $dto,
        array $new_data
    ){
        $snapshot = $this->getCreditLimitBalanceSnapshotBasedOnModality($dto);
        $history_id = $this->createHistory($dto)->id;
        return $this->monthly_credit_limit_balance_history_use_case->handle(
            new CreateMonthlyCreditLimitBalanceHistoryDTO(
                Carbon::now(),
                AmountInCents::fromInteger($dto->getUsedAmount()),
                AmountInCents::fromInteger($snapshot->total_used_amount),
                AmountInCents::fromInteger($new_data['total_used_amount']),
                AmountInCents::fromInteger($snapshot->balance),
                AmountInCents::fromInteger($new_data['balance']),
                $dto->getCreditLimitBalanceId(),
                $history_id,
                $dto->getContractId()
            )
        );
    }
}