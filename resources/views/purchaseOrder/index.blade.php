@extends('layout')

@section('content')

    <section class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold mb-1">Ordens de compra</h2>
            <p class="text-muted">Nesta tela você pode visualizar todas ordens de compra geradas pelo sistema Mantém.</p>
        </div>
    </section>

    <section>
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 pb-0">
                <h5 class="fw-semibold mb-0">Listagem das ordens de compra</h5>
            </div>

            <div class="card-body">

                <table class="table align-middle table-hover" id="purchase-order-list">
                    <thead class="table-light">
                        <tr>
                            <th>OC</th>
                            <th>Status</th>
                            <th>Itens</th>
                            <th>Fornecedor</th>
                            <th>Criado em</th>
                            <th>Criado por</th>
                            <th class="text-end">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
        </div>
    </section>

    {{-- Área de ações inferiores --}}
    <section class="mt-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-end">
                <a href="{{ url()->previous() }}" class="btn btn-outline-danger">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </section>
    
    @push('scripts')
        <script>
            const DATA = [
                ['external_display_id', 'OC'],
                ['status.name', 'Status'],
                ['total_items', 'Itens'],
                ['supplier.name', 'Fornecedor'],
                ['created_at', 'Criado em'],
                ['user.name', 'Criado por'],
                ['action', 'Ação', false, false],
            ];
            const ROUTE = @json(route('external-data.purchase-order.list'));
            $(document).ready(function(){
                const COLUMNS = prepareColumnsForYajra(DATA);
                buildYajra('purchase-order-list', COLUMNS, ROUTE);
            });
        </script>
    @endpush

@endsection
