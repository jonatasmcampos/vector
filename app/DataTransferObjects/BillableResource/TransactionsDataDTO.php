<?php

namespace App\DataTransferObjects\BillableResource;

use App\Domain\ValueObjects\Date;

class TransactionsDataDTO{

    private int $amount;
    private int $transaction_type_id;
    private Date $date;
    private int $user_id;
    private int $contract_id;
    private int $credit_limit_id;
    private int $credit_limit_balance_id;
    private ?int $installment_id;
    private string $transaction_entity_type;
    private int $transaction_entity_id;
    private string $balance_history_type;
    private int $balance_history_id;

    public function __construct(
        int $amount,
        int $transaction_type_id,
        Date $date,
        int $user_id,
        int $contract_id,
        int $credit_limit_id,
        int $credit_limit_balance_id,
        ?int $installment_id = null,
        string $transaction_entity_type,
        int $transaction_entity_id
    ){
        $this->amount = $amount;
        $this->transaction_type_id = $transaction_type_id;
        $this->date = $date;
        $this->user_id = $user_id;
        $this->contract_id = $contract_id;
        $this->credit_limit_id = $credit_limit_id;
        $this->credit_limit_balance_id = $credit_limit_balance_id;
        $this->installment_id = $installment_id;
        $this->transaction_entity_type = $transaction_entity_type;
        $this->transaction_entity_id = $transaction_entity_id;
    }

    public function getAmount(): int{
        return $this->amount;
    }

    public function getTransactionTypeId(): int{
        return $this->transaction_type_id;
    }

    public function getDate(): Date{
        return $this->date;
    }

    public function getUserId(): int{
        return $this->user_id;
    }

    public function getContractId(): int{
        return $this->contract_id;
    }

    public function getCreditLimitId(): int{
        return $this->credit_limit_id;
    }

    public function getCreditLimitBalanceId(): int{
        return $this->credit_limit_balance_id;
    }

    public function getInstallmentId(): ?int{
        return $this->installment_id;
    }

    public function getTransactionEntityType():string{
        return $this->transaction_entity_type;
    }

    public function getTransactionEntityId():int{
        return $this->transaction_entity_id;
    }

    public function getBalanceHistoryType():string{
        return $this->balance_history_type;
    }

    public function getBalanceHistoryId():int{
        return $this->balance_history_id;
    }

    public function setBalanceHistoryType(string $balance_history_type){
        $this->balance_history_type = $balance_history_type;
    }

    public function setBalanceHistoryId(int $balance_history_id){
        $this->balance_history_id = $balance_history_id;
    }


}