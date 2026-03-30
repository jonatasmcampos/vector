<?php 

namespace App\UseCases\CreditLimitHistories;

use App\DataTransferObjects\CreditLimitHistory\CreateCreditLimitHistoryDTO;
use App\Repositories\CreditLimitHistoryRepository;

class CreateCreditLimitHistoryUseCase{
    private CreditLimitHistoryRepository $credit_limit_repository;

    public function __construct(CreditLimitHistoryRepository $credit_limit_repository)
    {
        $this->credit_limit_repository = $credit_limit_repository;
    }

    public function handle(CreateCreditLimitHistoryDTO $create_credit_limit_history_dto){
        return $this->create($create_credit_limit_history_dto);
    }

    private function create(CreateCreditLimitHistoryDTO $create_credit_limit_history_dto){
        return $this->credit_limit_repository->create(
            $create_credit_limit_history_dto->getAuthorizedAmount()->value(),
            $create_credit_limit_history_dto->getOldAuthorizedAmount()->value(),
            $create_credit_limit_history_dto->getNewAuthorizedAmount()->value(),
            $create_credit_limit_history_dto->getDate(),
            $create_credit_limit_history_dto->getCreditLimitId(),
            $create_credit_limit_history_dto->getHistoryId(),
            $create_credit_limit_history_dto->getContractId(),
            $create_credit_limit_history_dto->getCreditUsageTypeId(),
            $create_credit_limit_history_dto->getCreditModalityId(),
            $create_credit_limit_history_dto->getCreditPeriodTypeId()
        );
    }
}