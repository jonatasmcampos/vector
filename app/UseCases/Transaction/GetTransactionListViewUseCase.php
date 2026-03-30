<?php

namespace App\UseCases\Transaction;

use App\DataTransferObjects\Transaction\GetTransactionListViewDTO;
use App\Domain\ValueObjects\AmountInCents;
use App\Enums\TransactionTypeEnum;
use App\Models\PurchaseOrder;
use App\Repositories\TransactionRepository;

class GetTransactionListViewUseCase{
    private TransactionRepository $transaction_repository;

    public function __construct(
        TransactionRepository $transaction_repository
    ){
        $this->transaction_repository = $transaction_repository;
    }

    public function handle(): array
    {
        return $this->getTransactions()
            ->map(fn ($transaction) => new GetTransactionListViewDTO(
                icon: $this->getTransactionIcon($transaction->transaction_type_id),
                text_class: $this->getTextClass($transaction->transaction_type_id),
                datetime: $transaction->date->format('d/m/Y H:i:s'),
                user: $transaction->user->name,
                transaction_type: $transaction->transaction_type->name,
                contract: $transaction->contract->name,
                transaction_entity: $this->getTransactionEntity(
                    $transaction->transaction_entity_type,
                    $transaction->transaction_entity->external_display_id
                ),
                payment_nature: $transaction->transaction_entity->payment_nature->name,
                payment_method: $transaction->transaction_entity->payment_method->name,
                installments_number: $transaction->transaction_entity->installments_number,
                amount: AmountInCents::fromInteger($transaction->amount)
                    ->toBRLMoney()->toString(),
                old_balance: AmountInCents::fromInteger(
                    $transaction->balance_history->old_balance
                )->toBRLMoney()->toString(),
                new_balance: AmountInCents::fromInteger(
                    $transaction->balance_history->new_balance
                )->toBRLMoney()->toString(),
            ))
            ->values()
            ->all();
    }

    private function getTransactions(){
        return $this->transaction_repository->getAll();
    }

    private function getTransactionIcon(
        int $transaction_type_id
    ): string{
        return match ($transaction_type_id) {
            TransactionTypeEnum::ACQUISITION->value => 'bi bi-arrow-down-circle',
            default => '',
        };
    }

    private function getTextClass(
        int $transaction_type_id
    ): string{
        return match ($transaction_type_id) {
            TransactionTypeEnum::ACQUISITION->value => 'text-danger',
            default => '',
        };
    }

    private function getTransactionEntity(
        string $transaction_entity_type,
        int $external_display_id
    ): string {
        return match ($transaction_entity_type) {
            PurchaseOrder::class => 'Ordem de compra #' . $external_display_id,
            default => '',
        };
    }


}