@extends('layout')

@section('content')

<section class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="fw-bold mb-1">
            Transações
        </h2>
        <p class="text-muted mb-0">
            Nesta tela você pode visualizar as transações realizadas em relação a um orçamento estipulado.
        </p>
    </div>
</section>

<section class="mb-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            @forelse ($transactions as $transaction)
                <div class="mb-4">
                    <div class="card border-0 shadow-sm mb-2">
                        
                        <div class="py-2 px-3">
                            <div class="d-flex justify-content-between">
                                <small class="text-muted fw-semibold">{{$transaction->date->format('d/m/Y h:m:s')}}</small>
                                <div class="d-flex align-items-center text-muted">
                                    Usuário: &nbsp; <h5 class="mb-0 fw-semibold">{{$transaction->user->name}}</h5>
                                </div>
                            </div>
                            <hr class="mt-2 mb-4">
                        </div>
                        <div class="card-body d-flex justify-content-between">
                            <div class="d-flex gap-3">
                                @if($transaction->transaction_type_id == App\Enums\TransactionTypeEnum::ACQUISITION->value)
                                    <div class="text-danger fs-4">
                                        <i class="bi bi-arrow-down-circle"></i>
                                    </div>
                                @endif

                                <div>
                                    <div class="fw-semibold text-danger">
                                        {{$transaction->transaction_type->name}}
                                    </div>                                    

                                    <div class="small">
                                        {{$transaction->contract->name}}
                                    </div>

                                    <div class="small">
                                        @if($transaction->transaction_entity_type == 'App\Models\PurchaseOrder')
                                            Ordem de compra #{{$transaction->transaction_entity->external_display_id}}
                                            <br>
                                            {{$transaction->transaction_entity->payment_method->name}}
                                            |
                                            {{$transaction->transaction_entity->payment_nature->name}}
                                            |
                                            {{$transaction->transaction_entity->installments_number}}x
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                                 @if($transaction->transaction_type_id == App\Enums\TransactionTypeEnum::ACQUISITION->value)
                                    <div class="fw-bold text-danger fs-5">
                                        R${{App\Domain\ValueObjects\AmountInCents::fromInteger($transaction->amount)->toBRLMoney()->toString()}}
                                    </div>
                                @endif

                                <div class="text-muted small">
                                    Saldo: R${{App\Domain\ValueObjects\AmountInCents::fromInteger($transaction->balance_history->old_balance)->toBRLMoney()->toString()}} 
                                    <i class="bi bi-chevron-compact-right"></i> 
                                    R${{App\Domain\ValueObjects\AmountInCents::fromInteger($transaction->balance_history->new_balance)->toBRLMoney()->toString()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <span class="badge badge-info">Nenhuma transação realizada!</span>
            @endforelse
        </div>
    </div>
</section>

<section class="mt-4">
    <div class="card border-0 shadow-sm">
        <div class="card-body text-end">
            <a href="{{ url()->previous() }}" class="btn btn-outline-danger">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
</section>

@endsection
