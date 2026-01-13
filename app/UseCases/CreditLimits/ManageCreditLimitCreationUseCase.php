<?php

namespace App\UseCases\CreditLimits;

use App\DataTransferObjects\CreditLimits\CreateCreditLimitDTO;
use App\Models\CreditLimit;
use App\Repositories\CreditLimitRepository;
use Carbon\Carbon;

final class ManageCreditLimitCreationUseCase{

    private CreateCreditLimitFactory $create_credit_limit_factory;
    private CreditLimitRepository $credit_limit_repository;

    public function __construct(
        CreateCreditLimitFactory $create_credit_limit_factory,
        CreditLimitRepository $credit_limit_repository
    ){
        $this->create_credit_limit_factory = $create_credit_limit_factory;
        $this->credit_limit_repository = $credit_limit_repository;
    }

    public function handle(CreateCreditLimitDTO $dto): void{
        $this->validate($dto);
        $strategy = $this->create_credit_limit_factory->make($dto->getCreditPeriodTypeId());
        $strategy->execute($dto);
    }

    private function validate(CreateCreditLimitDTO $dto): void{
        $credit_limit = $this->getCreditLimit(
            $dto->getReferenceMonth(),
            (int)Carbon::now()->format('Y'),
            $dto->getContractId(),
            $dto->getCreditUsageTypeId(),
            $dto->getCreditModalityId()
        );
        if($credit_limit){
            throw new \Exception("Limite já cadastrado!", 500);
        }
    }

    private function getCreditLimit(
        int $month,
        int $year,
        int $contract_id,
        int $credit_usage_type_id,
        int $credit_modality_id
    ): ?CreditLimit{
        return $this->credit_limit_repository->getCreditLimit(
            $month,
            $year,
            $contract_id,
            $credit_usage_type_id,
            $credit_modality_id
        );
    }

}