@extends('layout')

@section('content')

    <section class="mb-4">
        <h2 class="fw-bold mb-1">Novo limite</h2>
        <p class="text-muted">Nesta tela você pode cadastrar um novo limite de crédito.</p>
    </section>

    <section>
        <div class="card shadow-sm border-0 py-3">
            <div class="card-header bg-white border-0 pb-0">
                <h5 class="fw-semibold mb-0">Informações para cadastro</h5>
            </div>

            <div class="card-body">
                <form id="form_create_limit">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="select_contract">Contrato: <span style="color: red">*</span></label>
                            <select required name="contract_id" id="select_contract" class="form-select">
                                <option value="">Selectione um contrato ... </option>
                                @foreach ($contracts as $index => $contract)
                                    <option value="{{$index}}">{{$contract}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-xl-4 mb-3 mb-xl-0">
                            <label for="input_authorized_amount">Valor autorizado: <span style="color: red">*</span></label>
                            <input class="form-control" type="text" id="input_authorized_amount" required name="authorized_amount">
                        </div>
                        <div class="col-12 col-xl-4 mb-3 mb-xl-0">
                            <label for="select_usage_type">Este limite sera usado para: <span style="color: red">*</span></label>
                            <select required name="credit_usage_type_id" id="select_usage_type" class="form-select">
                                <option value="">Selectione a finalidade ... </option>
                                @foreach ($credit_usage_types as $credit_usage_type_id => $credit_usage_type)
                                    <option value="{{ $credit_usage_type_id }}">{{ $credit_usage_type['description'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-xl-4 mb-3 mb-xl-0">
                            <label for="select_period_types">Vigência: <span style="color: red">*</span></label>
                            <select required name="credit_period_type_id" id="select_period_types" class="form-select">
                                @if($settings['monthly_credit_period'])
                                    <option value="{{ App\Enums\CreditPeriodTypeEnum::MONTHLY->value}}" selected>{{ $credit_period_types[App\Enums\CreditPeriodTypeEnum::MONTHLY->value] }}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    @include('creditLimit.monthlyCreditPeriodFields')
                </form>
            </div>
        </div>
    </section>

    <section class="mt-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-end">
                <a href="{{ url()->previous() }}" class="btn btn-outline-danger">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
                <button class="btn btn-dark ms-2" id="btn_create_limit"> <i class="bi bi-floppy me-1"></i> Salvar</button>
            </div>
        </div>
    </section>
    
    @push('scripts')
        <script>
            $(document).ready(function(){
                applyMaskToTheAmountField();
                saveTheNewLimitListener();
            });

            function applyMaskToTheAmountField(){
                $('#input_authorized_amount').mask('0.000.000,00', {reverse: true});
            }

            function saveTheNewLimitListener(){
                $('#btn_create_limit').on('click', function(){
                    const form = $('#form_create_limit')[0];
                    if (!form.checkValidity()) {
                        form.reportValidity();
                        return;
                    }
                    disableButton('btn_create_limit');
                    $.ajax({
                        url: @json(route('manage.limits.store')),
                        headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                        method: 'POST',
                        data: $('#form_create_limit').serialize(),
                        success: function(response){
                            toastr.success(response.message);
                            $('#form_create_limit')[0].reset();
                            enableButton('btn_create_limit');
                        },
                        error: function(err){
                            if(err.responseJSON.errors){
                                toastr.error(err.responseJSON.errors);
                            } else {
                                toastr.error(err.responseJSON.message);
                            }
                            enableButton('btn_create_limit');
                        }
                    });
                });
            }
        </script>
    @endpush
@endsection
