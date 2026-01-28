<?php

namespace App\UseCases\CreditLimitBalances;

use App\DataTransferObjects\CreditLimitBalance\GetCreditLimitBalanceDTO;
use App\Domain\Contracts\CreditLimitBalance\GetCreditLimitBalanceInterface;
use App\Domain\ValueObjects\CreditLimitBalanceSnapshot;
use App\Enums\CreditModalityEnum;
use App\Enums\CreditPeriodTypeEnum;
use App\Repositories\MonthlyCreditLimitBalanceRepository;
use Carbon\Carbon;

class GetMonthlyCreditLimitBalanceStrategy implements GetCreditLimitBalanceInterface{

    private MonthlyCreditLimitBalanceRepository $monthly_credit_limit_balance_repository;

    public function __construct(
        MonthlyCreditLimitBalanceRepository $monthly_credit_limit_balance_repository
    ){
        $this->monthly_credit_limit_balance_repository = $monthly_credit_limit_balance_repository;
    }

    public function supports(int $credit_period_type_id): bool
    {
        return CreditPeriodTypeEnum::MONTHLY->value === $credit_period_type_id;
    }

    public function execute(GetCreditLimitBalanceDTO $get_credit_limit_balance_dto): CreditLimitBalanceSnapshot
    {
        $this->assertMonthIsValid($get_credit_limit_balance_dto);

        $credit_limit_balance = $this->monthly_credit_limit_balance_repository->getMonthlyCreditLimitBalanceToCheck(
            $get_credit_limit_balance_dto->getMonth(),
            $get_credit_limit_balance_dto->getYear(),
            $get_credit_limit_balance_dto->getContractId(),
            $get_credit_limit_balance_dto->getCreditUsageTypeId(),
            $get_credit_limit_balance_dto->getCreditModalityId()
        );

        return new CreditLimitBalanceSnapshot(
            $credit_limit_balance->id,
            CreditPeriodTypeEnum::MONTHLY->value,
            $credit_limit_balance->balance,
            $credit_limit_balance->total_used_amount,
            $credit_limit_balance->contract_id,
            $credit_limit_balance->credit_limit_id
        );
    }

    private function assertMonthIsValid(GetCreditLimitBalanceDTO $dto): void
    {
        $requested = Carbon::create($dto->getYear(), $dto->getMonth(), 1);
        $current   = Carbon::now()->startOfMonth();

        if ($requested->lt($current)) {
            throw new \Exception('Não há limite de crédito cadastrado para o mês atual!');
        }
    }
}