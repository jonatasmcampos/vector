<?php

namespace App\UseCases\CreditLimitBalances;

use App\DataTransferObjects\CreditLimitBalance\VerifyAcquisitionBalanceDTO;

class VerifyAcquisitionBalanceUseCase{

    public function __construct(){}

    public function validate(VerifyAcquisitionBalanceDTO $verify_balance_dto){
        return $this->verifyBalance($verify_balance_dto);
    }

    private function verifyBalance(VerifyAcquisitionBalanceDTO $verify_balance_dto){
        $this->checkAquisitionBalance(
            $verify_balance_dto->getCurrentAcquisitionBalance(),
            $verify_balance_dto->getTotalAmount()
        );
        return true;
    }

    private function checkAquisitionBalance(
        int $current_balance,
        int $purchase_order_total
    ){
        if($purchase_order_total > $current_balance){
            throw new \Exception("Não há saldo de aquisição suficiente para prosseguir!", 500);
        }
        return true;
    }

}