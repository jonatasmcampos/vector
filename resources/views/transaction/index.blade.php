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
                                <small class="text-muted fw-semibold">{{$transaction->datetime}}</small>
                                <div class="d-flex align-items-center text-muted small">
                                    Usuário: &nbsp; {{$transaction->user}}
                                </div>
                            </div>
                            <hr class="mt-1 mb-0">
                        </div>
                        <div class="card-body d-flex justify-content-between">
                            <div class="d-flex gap-2">
                                <div class="{{$transaction->text_class}} fs-4">
                                    <i class="{{$transaction->icon}}"></i>
                                </div>

                                <div>
                                    <div class="fw-semibold text-danger">
                                        {{$transaction->transaction_type}}
                                    </div>                                    

                                    <div class="small">
                                        {{$transaction->contract}}
                                    </div>

                                    <div class="small">
                                            {{$transaction->transaction_entity}}
                                            <br>
                                            {{$transaction->payment_method}}
                                            |
                                            {{$transaction->payment_nature}}
                                            |
                                            {{$transaction->installments_number}}x
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                                <div class="fw-bold {{$transaction->text_class}} fs-5">
                                    R$ {{$transaction->amount}}
                                </div>

                                <div class="text-muted small">
                                    Saldo: R${{$transaction->old_balance}} 
                                    <i class="bi bi-chevron-compact-right"></i> 
                                    R${{$transaction->new_balance}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
            <div class="text-center">
                <span class="text-center badge bg-info w-100 py-2">Nenhuma transação realizada!</span>
            </div>
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
