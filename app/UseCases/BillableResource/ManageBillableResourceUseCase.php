<?php

namespace App\UseCases\BillableResource;

use App\DataTransferObjects\BillableResource\TransactionsDataDTO;
use App\DataTransferObjects\CreditLimitBalance\UpdateCreditLimitBalanceDTO;
use App\DataTransferObjects\CreditLimitBalance\VerifyAcquisitionBalanceDTO;
use App\DataTransferObjects\CreditLimitBalance\VerifyPaymentBalanceDTO;
use App\Domain\Contracts\BillableResource\BillableResourceInterface;
use App\Domain\ValueObjects\CreditLimitBalanceHistorySnapshot;
use App\Models\Transaction;
use App\UseCases\CreditLimitBalances\UpdateCreditLimitBalanceUseCase;
use App\UseCases\CreditLimitBalances\VerifyAcquisitionBalanceUseCase;
use App\UseCases\CreditLimitBalances\VerifyPaymentBalanceUseCase;
use App\UseCases\Transaction\CreateTransactionUseCase;

class ManageBillableResourceUseCase{

    private VerifyAcquisitionBalanceUseCase $verify_acquisition_balance_use_case;
    private VerifyPaymentBalanceUseCase $verify_payment_balance_use_case;
    private CreateTransactionUseCase $create_transaction_use_case;
    private UpdateCreditLimitBalanceUseCase $update_credit_limit_balance_use_case;

    public function __construct(
        VerifyAcquisitionBalanceUseCase $verify_acquisition_balance_use_case,
        VerifyPaymentBalanceUseCase $verify_payment_balance_use_case,
        CreateTransactionUseCase $create_transaction_use_case,
        UpdateCreditLimitBalanceUseCase $update_credit_limit_balance_use_case,
    ){
        $this->verify_acquisition_balance_use_case = $verify_acquisition_balance_use_case;
        $this->verify_payment_balance_use_case = $verify_payment_balance_use_case;
        $this->create_transaction_use_case = $create_transaction_use_case;
        $this->update_credit_limit_balance_use_case = $update_credit_limit_balance_use_case;
    }

    public function handle(BillableResourceInterface $billable_resource): void{

        $this->verifyBalance($billable_resource);

        $transaction_data = $billable_resource->execute();

        $balance_history = $this->manageBalanceUpdate($billable_resource, $transaction_data);

        $this->registerTransaction($transaction_data, $balance_history);
    }

    private function verifyBalance(BillableResourceInterface $billable_resource): void {
        $this->verify_acquisition_balance_use_case->validate(new VerifyAcquisitionBalanceDTO(
            $billable_resource->getTotalAmount(),
            $billable_resource->getAcquisitionCreditLimitBalanceSnapshot()->balance
        ));
        $this->verify_payment_balance_use_case->validate(new VerifyPaymentBalanceDTO(
            $billable_resource->getTotalAmount(),
            $billable_resource->getInstallments(),
            $billable_resource->getPaymentCreditLimitBalanceSnapshot()->balance
        ));
    }

    private function manageBalanceUpdate(
        BillableResourceInterface $billable_resource,
        TransactionsDataDTO $transaction_data
    ){
        return $this->update_credit_limit_balance_use_case->handle(
            new UpdateCreditLimitBalanceDTO(
                $transaction_data->getCreditLimitBalanceId(),
                $transaction_data->getCreditLimitId(),
                $billable_resource->getCreditPeriodTypeId(),
                $transaction_data->getContractId(),
                $billable_resource->getCreditUsageTypeId(),
                $billable_resource->getCreditModalityId(),
                $transaction_data->getAmount(),
                $billable_resource->getAcquisitionCreditLimitBalanceSnapshot(),
                $billable_resource->getPaymentCreditLimitBalanceSnapshot(),
                $transaction_data->getUserId()
            )
        );
    }

    private function registerTransaction(
        TransactionsDataDTO $transaction_data,
        CreditLimitBalanceHistorySnapshot $balance_history
    ): Transaction{
        $transaction_data->setBalanceHistoryId($balance_history->credit_limit_balance_history_id);
        $transaction_data->setBalanceHistoryType($balance_history->credit_limit_balance_history_type);
        return $this->create_transaction_use_case->handle($transaction_data);
    }
}