<?php

namespace App\UseCases\CreditLimitBalances;

use App\DataTransferObjects\CreditLimitBalance\VerifyBalanceDTO;
use App\Domain\ValueObjects\AmountInCents;
use App\Domain\ValueObjects\Date;
use App\Enums\CreditModalityEnum;
use App\Enums\CreditUsageTypeEnum;
use App\Models\CreditLimitBalance;
use App\Repositories\CreditLimitBalanceRepository;
use Carbon\Carbon;

class VerifyBalanceUseCase{

    private CreditLimitBalanceRepository $credit_limit_balance_repository;

    public function __construct(
        CreditLimitBalanceRepository $credit_limit_balance_repository
    ){
        $this->credit_limit_balance_repository = $credit_limit_balance_repository;
    }

    public function validate(VerifyBalanceDTO $verify_balance_dto){
        return $this->verifyBalance($verify_balance_dto);
    }

    private function verifyBalance(VerifyBalanceDTO $verify_balance_dto){
        $credit_limit_balance_aquisition = $this->getCreditLimitBalance(
            $verify_balance_dto->getActionDate()->format('m'),
            $verify_balance_dto->getActionDate()->format('Y'),
            $verify_balance_dto->getContractId(),
            CreditModalityEnum::ACQUISITION->value
        );
        $credit_limit_balance_payment = $this->getCreditLimitBalance(
            $verify_balance_dto->getActionDate()->format('m'),
            $verify_balance_dto->getActionDate()->format('Y'),
            $verify_balance_dto->getContractId(),
            CreditModalityEnum::PAYMENT->value
        );

        $this->checkAquisitionBalance($credit_limit_balance_aquisition, $verify_balance_dto->getTotalAmount());
        $this->checkPaymentBalance($credit_limit_balance_payment, $verify_balance_dto->getInstallments());
        return true;
    }

    private function getCreditLimitBalance(
        $month,
        $year,
        $contract_id,
        $credit_modality_id
    ){
        return $this->credit_limit_balance_repository->getCreditLimitBalanceToCheck(
            $month,
            $year,
            $contract_id,
            CreditUsageTypeEnum::SUPPLY->value,
            $credit_modality_id
        );
    }

    private function checkAquisitionBalance(
        CreditLimitBalance $credit_limit_balance,
        int $purchase_order_total
    ){
        $balance = $credit_limit_balance->balance;
        return $this->validateBalance($purchase_order_total, $balance);
    }

    private function checkPaymentBalance(
        CreditLimitBalance $credit_limit_balance,
        array $installments
    ){
        $balance = $credit_limit_balance->balance;
        $payment_amount = $this->getInstallmentAmountForThisMonth($installments);
        return $this->validateBalance($payment_amount, $balance);
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