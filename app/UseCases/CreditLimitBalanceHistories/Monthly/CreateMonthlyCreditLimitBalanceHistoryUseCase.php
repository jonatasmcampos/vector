<?php 

namespace App\UseCases\CreditLimitBalanceHistories\Monthly;

use App\DataTransferObjects\CreditLimitBalanceHistory\CreateMonthlyCreditLimitBalanceHistoryDTO;
use App\Repositories\MonthlyCreditLimitBalanceHistoryRepository;

class CreateMonthlyCreditLimitBalanceHistoryUseCase{
    private MonthlyCreditLimitBalanceHistoryRepository $monthly_credit_limit_balance_repository;

    public function __construct(MonthlyCreditLimitBalanceHistoryRepository $monthly_credit_limit_balance_repository)
    {
        $this->monthly_credit_limit_balance_repository = $monthly_credit_limit_balance_repository;
    }

    public function handle(CreateMonthlyCreditLimitBalanceHistoryDTO $create_monthly_credit_limit_balance_history_dto){
        return $this->create($create_monthly_credit_limit_balance_history_dto);
    }

    private function create(CreateMonthlyCreditLimitBalanceHistoryDTO $create_monthly_credit_limit_balance_history_dto){
        return $this->monthly_credit_limit_balance_repository->create(
            $create_monthly_credit_limit_balance_history_dto->getDate(),
            $create_monthly_credit_limit_balance_history_dto->getUsedAmount()->value(),
            $create_monthly_credit_limit_balance_history_dto->getOldUsedAmount()->value(),
            $create_monthly_credit_limit_balance_history_dto->getNewUsedAmount()->value(),
            $create_monthly_credit_limit_balance_history_dto->getOldBalance()->value(),
            $create_monthly_credit_limit_balance_history_dto->getNewBalance()->value(),
            $create_monthly_credit_limit_balance_history_dto->getCreditLimitBalanceId(),
            $create_monthly_credit_limit_balance_history_dto->getHistoryId(),
            $create_monthly_credit_limit_balance_history_dto->getContractId()
        );
    }
}