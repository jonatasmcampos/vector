<?php

namespace App\UseCases\Transaction;

use App\DataTransferObjects\BillableResource\TransactionsDataDTO;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;

class CreateTransactionUseCase{

    private TransactionRepository $transaction_repository;

    public function __construct(
        TransactionRepository $transaction_repository
    ){
        $this->transaction_repository = $transaction_repository;
    }

    public function handle(
        TransactionsDataDTO $transaction_data_dto
    ){
        return $this->create($transaction_data_dto);
    }

    private function create(
        TransactionsDataDTO $transaction_data_dto
    ): Transaction{
        return $this->transaction_repository->create(
            $transaction_data_dto->getAmount(),
            $transaction_data_dto->getTransactionTypeId(),
            $transaction_data_dto->getDate()->value(),
            $transaction_data_dto->getUserId(),
            $transaction_data_dto->getContractId(),
            $transaction_data_dto->getCreditLimitId(),
            $transaction_data_dto->getInstallmentId(),
            $transaction_data_dto->getTransactionEntityType(),
            $transaction_data_dto->getTransactionEntityId(),
            $transaction_data_dto->getBalanceHistoryType(),
            $transaction_data_dto->getBalanceHistoryId()
        );
    }
}