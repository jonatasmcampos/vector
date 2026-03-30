@extends('layout')

@section('content')

{{-- HEADER --}}
<section class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="fw-bold mb-1">
            Ordem de Compra #{{ $purchase_order->external_display_id }}
        </h2>
        <p class="text-muted mb-0">
            Visualização completa da ordem de compra
        </p>
    </div>
</section>

{{-- DADOS GERAIS --}}
<section class="mb-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="fw-semibold mb-3">Informações Gerais</h5>

            <div class="row g-3">
                <div class="col-md-3">
                    <small class="text-muted">Contrato</small>
                    <div>{{ $purchase_order->contract?->name ?? '-' }}</div>
                </div>
                
                <div class="col-md-3">
                    <small class="text-muted">Usuário</small>
                    <div>{{ $purchase_order->user?->name ?? '-' }}</div>
                </div>

                <div class="col-md-3">
                    <small class="text-muted">Fornecedor</small>
                    <div>{{ $purchase_order->supplier?->name ?? '-' }}</div>
                </div>

                <div class="col-md-3">
                    <small class="text-muted">Status</small>
                    <div class="fw-semibold">
                        {{ App\Enums\StatusEnum::badge($purchase_order->status_id) }}
                    </div>
                </div>

                <div class="col-md-3">
                    <small class="text-muted">Total de Itens</small>
                    <div>{{ $purchase_order->total_items }}</div>
                </div>

                <div class="col-md-3">
                    <small class="text-muted">Frete CIF</small>
                    <div>
                        R$ {{ App\Domain\ValueObjects\AmountInCents::fromInteger($purchase_order->cif)->toBRLMoney()->toString() }}
                    </div>
                </div>

                <div class="col-md-3">
                    <small class="text-muted">Frete FOB</small>
                    <div>
                        R$ {{ App\Domain\ValueObjects\AmountInCents::fromInteger($purchase_order->fob)->toBRLMoney()->toString() }}
                    </div>
                </div>

                <div class="col-md-3">
                    <small class="text-muted">Desconto</small>
                    <div>
                        R$ {{ App\Domain\ValueObjects\AmountInCents::fromInteger($purchase_order->discount)->toBRLMoney()->toString() }}
                    </div>
                </div>

                <div class="col-md-3">
                    <small class="text-muted">Total</small>
                    <div class="fw-semibold">
                        R$ {{ App\Domain\ValueObjects\AmountInCents::fromInteger($purchase_order->total)->toBRLMoney()->toString() }}
                    </div>
                </div>

                <div class="col-md-3">
                    <small class="text-muted">Natureza de Pagamento</small>
                    <div>{{ $purchase_order->payment_nature?->name ?? '-' }}</div>
                </div>

                <div class="col-md-3">
                    <small class="text-muted">Método de Pagamento</small>
                    <div>{{ $purchase_order->payment_method?->name ?? '-' }}</div>
                </div>

                <div class="col-md-3">
                    <small class="text-muted">Número de Parcelas</small>
                    <div>{{ $purchase_order->installments_number }}</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ITENS DA ORDEM --}}
<section class="mb-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="fw-semibold mb-3">Itens da Compra</h5>

            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Material</th>
                            <th class="text-center">Quantidade</th>
                            <th class="text-end">Valor Unitário</th>
                            <th class="text-end">Valor Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($purchase_order->purchase_order_items as $item)
                            <tr>
                                <td>{{ $item->material }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end">
                                    R$ {{ App\Domain\ValueObjects\AmountInCents::fromInteger($item->unit_amount)->toBRLMoney()->toString() }}
                                </td>
                                <td class="text-end">
                                    R$ {{ App\Domain\ValueObjects\AmountInCents::fromInteger($item->total_amount)->toBRLMoney()->toString() }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Nenhum item encontrado
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

{{-- PARCELAS --}}
<section class="mb-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="fw-semibold mb-3">Parcelas</h5>

            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Vencimento</th>
                            <th class="text-end">Valor</th>
                            <th>Pago em</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($purchase_order->installments as $installment)
                            <tr>
                                <td>{{ $installment->order }}</td>
                                <td>{{ $installment->due_day->format('d/m/Y') }}</td>
                                <td class="text-end">
                                    R$ {{ App\Domain\ValueObjects\AmountInCents::fromInteger($installment->installment_amount)->toBRLMoney()->toString() }}
                                </td>
                                <td>
                                    {{$installment->paid_at ?? '-'}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Nenhuma parcela encontrada
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

{{-- FOOTER --}}
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
