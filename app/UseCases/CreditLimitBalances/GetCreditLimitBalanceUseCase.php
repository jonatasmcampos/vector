<?php

namespace App\UseCases\CreditLimitBalances;

use App\DataTransferObjects\CreditLimitBalance\GetCreditLimitBalanceDTO;
use App\Domain\ValueObjects\CreditLimitBalanceSnapshot;
use App\Models\CreditLimit;
use App\Repositories\CreditLimitRepository;
use App\UseCases\CreditLimitBalances\GetCreditLimitBalanceFactory;

class GetCreditLimitBalanceUseCase{

    private GetCreditLimitBalanceFactory $get_credit_limit_balance_factory;
    private CreditLimitRepository $credit_limit_repository;

    public function __construct(
        GetCreditLimitBalanceFactory $get_credit_limit_balance_factory,
        CreditLimitRepository $credit_limit_repository
    ){
        $this->get_credit_limit_balance_factory = $get_credit_limit_balance_factory;
        $this->credit_limit_repository = $credit_limit_repository;
    }

    public function handle(GetCreditLimitBalanceDTO $dto): CreditLimitBalanceSnapshot{
        $credit_limit = $this->getCreditLimit($dto);
        $strategy = $this->get_credit_limit_balance_factory->make($credit_limit->credit_period_type_id);
        return $strategy->execute($dto);
    }

    private function getCreditLimit(GetCreditLimitBalanceDTO $dto): ?CreditLimit{
        $credit_limit = $this->credit_limit_repository->getCreditLimit(
            $dto->getMonth(),
            $dto->getYear(),
            $dto->getContractId(),
            $dto->getCreditUsageTypeId(),
            $dto->getCreditModalityId()
        );
        if(!$credit_limit){
            throw new \Exception("Limite de crédito não encontrado!", 404);
        }
        return $credit_limit;
    }

}