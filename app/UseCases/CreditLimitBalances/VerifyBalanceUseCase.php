<?php

namespace App\UseCases\CreditLimitBalances;

use App\DataTransferObjects\CreditLimitBalance\VerifyBalanceDTO;
use App\Domain\ValueObjects\AmountInCents;
use App\Domain\ValueObjects\Date;
use App\Models\Settings;
use Carbon\Carbon;
class VerifyBalanceUseCase{

    public function __construct(){}

    public function validate(VerifyBalanceDTO $verify_balance_dto){
        return $this->verifyBalance($verify_balance_dto);
    }

    private function verifyBalance(VerifyBalanceDTO $verify_balance_dto){

        $validatePayment = (bool) Settings::where(
            'key',
            'validate-balance.purchase-order-payment-on-acquisition'
        )->value('value');

        $this->checkAquisitionBalance(
            $verify_balance_dto->getCurrentAcquisitionBalance(),
            $verify_balance_dto->getTotalAmount()
        );

        if ($validatePayment) {
            $this->checkPaymentBalance(
                $verify_balance_dto->getCurrentPaymentBalance(),
                $verify_balance_dto->getInstallments()
            );
        }
        return true;
    }

    private function checkAquisitionBalance(
        int $current_balance,
        int $purchase_order_total
    ){
        return $this->validateBalance($purchase_order_total, $current_balance);
    }

    private function checkPaymentBalance(
        int $current_balance,
        array $installments
    ){
        $payment_amount = $this->getInstallmentAmountForThisMonth($installments);
        return $this->validateBalance($payment_amount, $current_balance);
    }

    private function getInstallmentAmountForThisMonth(
        array $installments
    ){
        $installments_for_this_month = array_filter($installments, function($installment){
            return Date::fromString($installment['due_day'])->format('Y-m') == Carbon::now()->format('Y-m');
        });
        $total_amount = collect($installments_for_this_month)->sum('installment_amount');
        return AmountInCents::fromFloat($total_amount)->value();
    }

    private function validateBalance(
        int $total_amount,
        int $balance
    ){
        if($total_amount > $balance){
            throw new \Exception("Não há saldo suficiente para prosseguir!", 500);
        }
        return true;
    }
}