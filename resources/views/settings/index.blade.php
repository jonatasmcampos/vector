@extends('layout')

@section('content')

<section class="mb-4">
    <h2 class="fw-bold mb-1">Configurações</h2>
    <p class="text-muted mb-0">
        Gerencie preferências e validações do sistema.
    </p>
</section>

<section class="row g-4">

    <div class="col-lg-3 col-md-4 col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-2">
                <ul class="list-group list-group-flush">

                    <li class="list-group-item list-group-item-action 
                        {{ $section == 'profile' ? 'active fw-semibold' : '' }}">
                        <a href="?section=profile" class="text-decoration-none text-reset">
                            <i class="bi bi-person me-2"></i> Meus dados
                        </a>
                    </li>

                    <li class="list-group-item list-group-item-action 
                        {{ $section == 'validateBalance' ? 'active fw-semibold' : '' }}">
                        <a href="?section=validateBalance" class="text-decoration-none text-reset">
                            <i class="bi bi-shield-check me-2"></i> Validação de saldos
                        </a>
                    </li>

                    <li class="list-group-item list-group-item-action 
                        {{ $section == 'limit' ? 'active fw-semibold' : '' }}">
                        <a href="?section=limit" class="text-decoration-none text-reset">
                            <i class="bi bi-graph-up-arrow me-2"></i> Limites
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-9 col-md-8 col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                @includeIf("settings.$section")
            </div>
        </div>
    </div>

    <section class="mt-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-end">
                <a href="{{ url()->previous() }}" class="btn btn-outline-danger">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </section>

</section>

@endsection
