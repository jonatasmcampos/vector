<?php

namespace App\UseCases\CreditLimitBalances;

use App\DataTransferObjects\CreditLimitBalance\VerifyPaymentBalanceDTO;
use App\Domain\ValueObjects\AmountInCents;
use App\Domain\ValueObjects\Date;
use App\Repositories\SettingsRepository;
use Carbon\Carbon;

class VerifyPaymentBalanceUseCase{

    private SettingsRepository $settings_repository;

    public function __construct(
        SettingsRepository $settings_repository
    ){
        $this->settings_repository = $settings_repository;
    }

    public function validate(VerifyPaymentBalanceDTO $verify_balance_dto){
        return $this->verifyBalance($verify_balance_dto);
    }

    private function verifyBalance(VerifyPaymentBalanceDTO $verify_balance_dto){
        if ($this->shouldValidatePaymentBalance()) {
            $this->checkPaymentBalance(
                $verify_balance_dto->getCurrentPaymentBalance(),
                $verify_balance_dto->getInstallments()
            );
        }
        return true;
    }

    private function checkPaymentBalance(
        int $current_balance,
        array $installments
    ){
        $payment_amount = $this->getInstallmentAmountForThisMonth($installments);
        if($payment_amount > $current_balance){
            throw new \Exception("Não há saldo de pagamento suficiente para prosseguir!", 500);
        }
        return true;        
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

    private function shouldValidatePaymentBalance(): bool{
        return $this->settings_repository->getByKey('validate-balance.purchase-order-payment-on-acquisition')->value;
    }

}