<?php

namespace App\UseCases\BillableResource;

use App\DataTransferObjects\CreditLimitBalance\VerifyBalanceDTO;
use App\Domain\Contracts\BillableResource\BillableResourceInterface;
use App\UseCases\CreditLimitBalances\VerifyBalanceUseCase;

class ManageBillableResourceUseCase{

    private VerifyBalanceUseCase $verify_balance_use_case;

    public function __construct(
        VerifyBalanceUseCase $verify_balance_use_case
    ){
        $this->verify_balance_use_case = $verify_balance_use_case;
    }

    public function handle(BillableResourceInterface $billable_resource): void{
        $verify_balance_dto = $this->getVerifyBalanceDTO($billable_resource);
        $this->verify_balance_use_case->validate($verify_balance_dto);
        $billable_resource->execute();
    }

    private function getVerifyBalanceDTO(BillableResourceInterface $billable_resource): VerifyBalanceDTO{
        return new VerifyBalanceDTO(
            $billable_resource->getActionDate(),
            $billable_resource->getContractId(),
            $billable_resource->getTotalAmount(),
            $billable_resource->getInstallments()
        );
    }
}