@extends('layout')

@section('content')

    {{-- Header da página --}}
    <section class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold mb-1">Limites</h2>
            <p class="text-muted">Nesta tela você pode visualizar todos os limites cadastrados.</p>
        </div>
        <a href="{{route('manage.limits.create')}}" class="btn btn-dark h-100"> <i class="bi bi-plus"></i> Novo limite</a>
    </section>

    {{-- Card principal com a lista --}}
    <section>
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 pb-0">
                <h5 class="fw-semibold mb-0">Listagem dos Limites</h5>
            </div>

            <div class="card-body">

                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Contrato</th>
                            <th>Referência</th>
                            <th class="text-end">Ação</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>CT5</td>
                            <td>MAIO/2025</td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> Visualizar
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>CT6</td>
                            <td>MAIO/2025</td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> Visualizar
                                </button>
                            </td>
                        </tr>
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

@endsection
