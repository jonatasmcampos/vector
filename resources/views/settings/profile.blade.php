<h5 class="fw-semibold mb-3">Meus dados</h5>

<form class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Login</label>
        <input disabled type="text" class="form-control" value="{{ $data->user_login }}">
    </div>

    <div class="col-md-8">
        <label class="form-label">Nome</label>
        <input disabled type="text" class="form-control" value="{{ $data->user_name }}">
    </div>

    <div class="col-md-6">
        <label class="form-label">E-mail</label>
        <input disabled type="email" class="form-control" value="{{ $data->user_email }}">
    </div>

    @if($data->cpf)
        <div class="col-md-6">
            <label class="form-label">CPF</label>
            <input disabled type="text" class="form-control" value="{{App\Domain\ValueObjects\CPF::fromUnformatted($data->cpf)->value()}}">
        </div>
    @endif

    @if($data->phone)
        <div class="col-md-6">
            <label class="form-label">Telefone</label>
            <input disabled type="text" class="form-control" value="{{App\Domain\ValueObjects\Phone::fromUnformatted($data->phone)->value()}}">
        </div>
    @endif
</form>
