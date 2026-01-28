<?php

namespace App\UseCases\CreditLimits;

use App\DataTransferObjects\CreditLimitBalance\CreateMonthlyCreditLimitBalanceDTO;
use App\DataTransferObjects\CreditLimitBalanceHistory\CreateMonthlyCreditLimitBalanceHistoryDTO;
use App\DataTransferObjects\CreditLimitHistory\CreateCreditLimitHistoryDTO;
use App\DataTransferObjects\CreditLimits\CreateCreditLimitDTO;
use App\DataTransferObjects\Histories\CreateHistoryDTO;
use App\Domain\Contracts\CreditLimits\CreateCreditLimitInterface;
use App\Domain\ValueObjects\AmountInCents;
use App\Enums\ActionEnum;
use App\Enums\CreditPeriodTypeEnum;
use App\Enums\ProcessEnum;
use App\Models\CreditLimit;
use App\Models\MonthlyCreditLimitBalance;
use App\Models\History;
use App\UseCases\CreditLimitBalanceHistories\Monthly\CreateMonthlyCreditLimitBalanceHistoryUseCase;
use App\UseCases\CreditLimitBalances\Monthly\CreateMonthlyCreditLimitBalanceUseCase;
use App\UseCases\CreditLimitHistories\CreateCreditLimitHistoryUseCase;
use App\UseCases\Histories\CreateHistoryUseCase;
use Carbon\Carbon;

class CreateCreditLimitMonthlyStrategy implements CreateCreditLimitInterface{

    private CreateCreditLimitUseCase $create_credit_limit_use_case;
    private CreateMonthlyCreditLimitBalanceUseCase $create_monthly_credit_limit_balance_use_case;

    private CreateHistoryUseCase $create_history_use_case;
    private CreateCreditLimitHistoryUseCase $create_credit_limit_history_use_case;
    private CreateMonthlyCreditLimitBalanceHistoryUseCase $create_credit_limit_balance_history_use_case;

    public function __construct(
        CreateCreditLimitUseCase $create_credit_limit_use_case,
        CreateMonthlyCreditLimitBalanceUseCase $create_monthly_credit_limit_balance_use_case,
        CreateHistoryUseCase $create_history_use_case,
        CreateCreditLimitHistoryUseCase $create_credit_limit_history_use_case,
        CreateMonthlyCreditLimitBalanceHistoryUseCase $create_credit_limit_balance_history_use_case

    ){
        $this->create_credit_limit_use_case = $create_credit_limit_use_case;
        $this->create_monthly_credit_limit_balance_use_case = $create_monthly_credit_limit_balance_use_case;
        $this->create_history_use_case = $create_history_use_case;
        $this->create_credit_limit_history_use_case = $create_credit_limit_history_use_case;
        $this->create_credit_limit_balance_history_use_case = $create_credit_limit_balance_history_use_case;
    }

    public function supports(int $credit_period_type_id): bool
    {
        return $credit_period_type_id === CreditPeriodTypeEnum::MONTHLY->value;
    }

    public function execute(CreateCreditLimitDTO $create_credit_limit_dto): void
    {
        $credit_limit = $this->createCreditLimit($create_credit_limit_dto);
        $credit_limit_balance = $this->createBalanceForCreditLimit($credit_limit);

        $credit_limit_history = $this->createHistory(
            $create_credit_limit_dto->getUserId(),
            $create_credit_limit_dto->getContractId(),
            ActionEnum::MANAGE_CREATE_CREDIT_LIMIT->value,
            null
        );
        $credit_limit_balance_history = $this->createHistory(
            $create_credit_limit_dto->getUserId(),
            $create_credit_limit_dto->getContractId(),
            ActionEnum::MANAGE_CREATE_CREDIT_LIMIT_BALANCE->value,
            null
        );
        $this->createCreditLimitHistory($credit_limit, $credit_limit_history->id);
        $this->createCreditLimiBalancetHistory($credit_limit_balance, $credit_limit_balance_history->id);
    }

    private function createCreditLimit(CreateCreditLimitDTO $create_credit_limit_dto): CreditLimit{
        return $this->create_credit_limit_use_case->handle($create_credit_limit_dto);
    }

    private function createBalanceForCreditLimit(CreditLimit $credit_limit): MonthlyCreditLimitBalance{
        return $this->create_monthly_credit_limit_balance_use_case->handle(
            new CreateMonthlyCreditLimitBalanceDTO(
                AmountInCents::fromInteger(0),
                AmountInCents::fromInteger($credit_limit->authorized_amount),
                $credit_limit->contract_id,
                $credit_limit->id
            )
        );
    }

    private function createHistory(int $user_id, int $contract_id, int $action, ?string $observation = null): History{
        return $this->create_history_use_case->handle(
            new CreateHistoryDTO(
                Carbon::now(),
                $observation,
                $user_id,
                $action,
                ProcessEnum::MANAGE_LIMIT->value,
                $contract_id
            )
        );
    }

    private function createCreditLimitHistory(CreditLimit $credit_limit, int $history_id){
        $this->create_credit_limit_history_use_case->handle(
            new CreateCreditLimitHistoryDTO(
                AmountInCents::fromInteger($credit_limit->authorized_amount),
                AmountInCents::fromInteger(0),
                AmountInCents::fromInteger($credit_limit->authorized_amount),
                Carbon::now(),
                $credit_limit->id,
                $history_id,
                $credit_limit->contract_id,
                $credit_limit->credit_usage_type_id,
                $credit_limit->credit_modality_id,
                $credit_limit->credit_period_type_id,
            )
        );
    }

    private function createCreditLimiBalancetHistory(MonthlyCreditLimitBalance $credit_limit_balance, int $history_id){
        $this->create_credit_limit_balance_history_use_case->handle(
            new CreateMonthlyCreditLimitBalanceHistoryDTO(
                Carbon::now(),
                AmountInCents::fromInteger($credit_limit_balance->total_used_amount),
                AmountInCents::fromInteger(0),
                AmountInCents::fromInteger($credit_limit_balance->total_used_amount),
                AmountInCents::fromInteger(0),
                AmountInCents::fromInteger($credit_limit_balance->balance),
                $credit_limit_balance->id,
                $history_id,
                $credit_limit_balance->contract_id
            )
        );
    }

}