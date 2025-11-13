<?php

namespace App\UseCases\CreditLimitBalances;

use App\DataTransferObjects\CreditLimitBalance\CreateCreditLimitBalanceDTO;
use App\Models\CreditLimitBalance;
use App\Repositories\CreditLimitBalanceRepository;

class CreateCreditLimitBalanceUseCase{

    private CreditLimitBalanceRepository $credit_limit_balance_repository;

    public function __construct(CreditLimitBalanceRepository $credit_limit_balance_repository)
    {
        $this->credit_limit_balance_repository = $credit_limit_balance_repository;
    }

    public function handle(CreateCreditLimitBalanceDTO $create_credit_limit_balance_request){
        return $this->create($create_credit_limit_balance_request);
    }

    private function create(CreateCreditLimitBalanceDTO $create_credit_limit_balance_request): CreditLimitBalance{
        return $this->credit_limit_balance_repository->create(
            $create_credit_limit_balance_request->getTotalUsedAmount()->value(),
            $create_credit_limit_balance_request->getBalance()->value(),
            $create_credit_limit_balance_request->getContractId(),
            $create_credit_limit_balance_request->getCreditLimitId(),
        );
    }
}