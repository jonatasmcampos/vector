<?php 

namespace App\UseCases\CreditLimitBalanceHistories;

use App\DataTransferObjects\CreditLimitBalanceHistory\CreateCreditLimitBalanceHistoryDTO;
use App\Repositories\CreditLimitBalanceHistoryRepository;

class CreateCreditLimitBalanceHistoryUseCase{
    private CreditLimitBalanceHistoryRepository $credit_limit_balance_repository;

    public function __construct(CreditLimitBalanceHistoryRepository $credit_limit_balance_repository)
    {
        $this->credit_limit_balance_repository = $credit_limit_balance_repository;
    }

    public function handle(CreateCreditLimitBalanceHistoryDTO $create_credit_limit_balance_history_dto){
        return $this->create($create_credit_limit_balance_history_dto);
    }

    private function create(CreateCreditLimitBalanceHistoryDTO $create_credit_limit_balance_history_dto){
        return $this->credit_limit_balance_repository->create(
            $create_credit_limit_balance_history_dto->getDate(),
            $create_credit_limit_balance_history_dto->getUsedAmount()->value(),
            $create_credit_limit_balance_history_dto->getOldUsedAmount()->value(),
            $create_credit_limit_balance_history_dto->getNewUsedAmount()->value(),
            $create_credit_limit_balance_history_dto->getOldBalance()->value(),
            $create_credit_limit_balance_history_dto->getNewBalance()->value(),
            $create_credit_limit_balance_history_dto->getCreditLimitBalanceId(),
            $create_credit_limit_balance_history_dto->getHistoryId(),
            $create_credit_limit_balance_history_dto->getContractId()
        );
    }
}