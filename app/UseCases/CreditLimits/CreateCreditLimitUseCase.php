<?php

namespace App\UseCases\CreditLimits;

use App\DataTransferObjects\CreditLimits\CreateCreditLimitDTO;
use App\Models\CreditLimit;
use App\Repositories\CreditLimitRepository;

class CreateCreditLimitUseCase{

    private CreditLimitRepository $credit_limit_repository;

    public function __construct(CreditLimitRepository $credit_limit_repository)
    {
        $this->credit_limit_repository = $credit_limit_repository;
    }

    public function handle(CreateCreditLimitDTO $create_credit_limit_request){
        return $this->create($create_credit_limit_request);
    }

    private function create(CreateCreditLimitDTO $create_credit_limit_request): CreditLimit{
        return $this->credit_limit_repository->create(
            $create_credit_limit_request->getAuthorizedAmount()->value(),
            $create_credit_limit_request->getReferenceMonth(),
            $create_credit_limit_request->getContractId(),
            $create_credit_limit_request->getCreditUsageTypeId(),
            $create_credit_limit_request->getCreditModalityId(),
            $create_credit_limit_request->getCreditPeriodTypeId()
        );
    }
}