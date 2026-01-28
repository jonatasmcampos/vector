@extends('layout')
@section('content')
    <style>
        .stat-card {
            position: relative;
            border: none;
            border-radius: 1rem;
            overflow: hidden;
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 22px rgba(0, 0, 0, 0.12);
        }

        .stat-card h6 {
            text-transform: uppercase;
            font-size: 0.75rem;
            color: #6c757d;
            letter-spacing: 0.05em;
        }

        .stat-card h4 {
            font-weight: 700;
            font-size: 1.1rem;
            color: #212529;
            margin-bottom: 0.5rem;
        }

        .stat-card .value {
            font-size: 1.75rem;
            font-weight: 700;
            color: #89aaac;
            margin-top: 1rem;
        }

        .progress {
            height: 8px;
            border-radius: 5px;
            background-color: #f1f6fa;
            overflow: hidden;
        }

        .progress-bar {
            background-color: #999999;
            border-radius: 5px;
            height: 100%;
            transition: width 0.5s ease;
        }

        .progress-text {
            font-size: 0.85rem;
            font-weight: 600;
            color: #000;
            min-width: 40px;
            text-align: right;
        }
    </style>

    <section class="row mb-4 align-items-center">
        <div class="col-12 col-xl-6 mb-3 mb-xl-0">
            <h2 class="fw-bold mb-0">Dashboard</h2>
        </div>
        <div class="col-12 col-xl-6">
            <div class="row">
                <div class="col-12 col-xl-3 mb-3 mb-xl-0">
                    <label for="select_contract">Contrato</label>
                    <select class="form-select me-2" name="contract_id" id="select_contract">
                        @foreach ($contracts as $index => $contract)
                            <option value="{{$index}}" @if($index == App\Enums\ContractEnum::CT6->value) selected @endif>{{$contract}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-xl-3 mb-3 mb-xl-0">
                    <label for="select_reference_month">Mês de referência</label>
                    <select class="form-select" name="month" id="select_reference_month">
                        @foreach ($months as $index => $month)
                            <option value="{{$index + 1}}" @if($current_month == ($index+1)) selected @endif>{{$month}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-xl-3 mb-3 mb-xl-0">
                    <label for="select_reference_year">Ano de referência</label>
                    <select class="form-select" name="year" id="select_reference_year">
                        @foreach ($years as $index => $year)
                            <option value="{{$year}}" @if($current_year == $year) selected @endif>{{$year}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-xl-3 mb-3 mb-xl-0">
                    <label for="select_usage_type">Tipo de uso</label>
                    <select class="form-select me-2" name="credit_usage_type_id" id="select_usage_type">
                        @foreach ($credit_usage_types as $credit_usage_type_id => $credit_usage_type)
                            <option value="{{ $credit_usage_type_id }}">{{ $credit_usage_type }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div id="cards-container" class="row g-2"></div>
    </section>

    @push('scripts')
        <script>
            $(document).ready(function(){
                loadCards();
                $('#select_reference_month, #select_reference_year, #select_contract, #select_usage_type').on('change', loadCards);
            });

            async function loadCards(){
                const MONTH = $('#select_reference_month').val();
                const YEAR = $('#select_reference_year').val();
                const CONTRACT_ID = $('#select_contract').val();
                const CREDIT_USAGE_TYPE_ID = $('#select_usage_type').val();

                await $.ajax({
                    url: @json(route('view.home.load.cards')),
                    method: 'GET',
                    data: { month: MONTH, year: YEAR, contract_id: CONTRACT_ID, credit_usage_type_id: CREDIT_USAGE_TYPE_ID },
                    beforeSend: function() {
                        $('#cards-container').html('<div class="text-center py-4 w-100"><div class="spinner-border text-warning" role="status"></div></div>');
                    },
                    success: function(response){
                        buildCards(response);
                    },
                    error: function(err){
                        console.error(err.responseJSON);
                        toastr.error('Erro ao carregar os dados dos cards.');
                    }
                });
            }

            function buildCards(data_cards){
                $('#cards-container').empty();

                data_cards.forEach(card => {
                    $('#cards-container').append(`
                        <div class="col-12 col-xl-3">
                            <div class="mb-2">
                                <div class="card stat-card h-100">
                                    <div class="card-body p-4">
                                        <h6>${card.subtitle}</h6>
                                        <h4><i class="bi bi-bar-chart"></i> ${card.title}</h4>
                                        <div class="value">R$ ${card.value}</div>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 me-2">
                                                <div class="progress-bar"
                                                    role="progressbar"
                                                    style="width: ${card.progress}%;"
                                                    aria-valuenow="${card.progress}"
                                                    aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                            <span class="progress-text">${card.progress}%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                });
            }
        </script>
    @endpush
@endsection