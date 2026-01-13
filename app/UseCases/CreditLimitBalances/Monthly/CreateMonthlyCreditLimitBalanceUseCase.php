<?php

namespace App\UseCases\CreditLimitBalances\Monthly;

use App\DataTransferObjects\CreditLimitBalance\CreateMonthlyCreditLimitBalanceDTO;
use App\Models\MonthlyCreditLimitBalance;
use App\Repositories\MonthlyCreditLimitBalanceRepository;

class CreateMonthlyCreditLimitBalanceUseCase{

    private MonthlyCreditLimitBalanceRepository $monthly_credit_limit_balance_repository;

    public function __construct(MonthlyCreditLimitBalanceRepository $monthly_credit_limit_balance_repository)
    {
        $this->monthly_credit_limit_balance_repository = $monthly_credit_limit_balance_repository;
    }

    public function handle(CreateMonthlyCreditLimitBalanceDTO $create_credit_limit_balance_request){
        return $this->create($create_credit_limit_balance_request);
    }

    private function create(CreateMonthlyCreditLimitBalanceDTO $create_credit_limit_balance_request): MonthlyCreditLimitBalance{
        return $this->monthly_credit_limit_balance_repository->create(
            $create_credit_limit_balance_request->getTotalUsedAmount()->value(),
            $create_credit_limit_balance_request->getBalance()->value(),
            $create_credit_limit_balance_request->getContractId(),
            $create_credit_limit_balance_request->getCreditLimitId(),
        );
    }
}