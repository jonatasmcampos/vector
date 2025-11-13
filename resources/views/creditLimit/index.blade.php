@extends('layout')

@section('content')

    <section class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold mb-1">Limites</h2>
            <p class="text-muted">Nesta tela você pode visualizar todos os limites cadastrados.</p>
        </div>
        <a href="{{route('manage.limits.create')}}" class="btn btn-dark h-100"> <i class="bi bi-plus"></i> Novo limite</a>
    </section>

    <section>
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 pb-0">
                <h5 class="fw-semibold mb-0">Listagem dos Limites</h5>
            </div>

            <div class="card-body">

                <table class="table align-middle table-hover" id="credit_limits_list">
                    <thead class="table-light">
                        <tr>
                            <th>Contrato</th>
                            <th>Valor autorizado</th>
                            <th>Referência</th>
                            <th>Modalidade</th>
                            <th>Vigência</th>
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
                ['contract.name', 'Contrato'],
                ['authorized_amount', 'Valor autorizado'],
                ['month', 'Mês de referência'],
                ['credit_modality.name', 'Modalidade'],
                ['credit_usage_type.name', 'Tipo de uso'],
                ['credit_period_type.name', 'Vigência'],
                ['action', 'Ação', false, false],
            ];
            const ROUTE = @json(route('manage.limits.list'));
            $(document).ready(function(){
                const COLUMNS = prepareColumnsForYajra(DATA);
                buildYajra('credit_limits_list', COLUMNS, ROUTE);
            });
        </script>
    @endpush

@endsection
