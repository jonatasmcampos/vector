@if ($settings['monthly_credit_period'])
    <div class="row mb-3">
        <div class="col-12 col-xl-6">
            <label for="select_modality">Qual modalidade: <span style="color: red">*</span></label>
            <select required name="credit_modality_id" id="select_modality" class="form-select">
                <option value="">Selectione a modalidade ... </option>
                @foreach ($credit_modalities as $credit_modality_id => $credit_modality)
                    <option value="{{ $credit_modality_id }}">{{ $credit_modality }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-xl-6">
            <label for="select_reference_month">Mês de referência: <span style="color: red">*</span></label>
            <select required name="month" id="select_reference_month" class="form-select">
                <option value="">Selectione um mês de referência ... </option>
                @foreach ($months as $index => $month)
                    <option value="{{ $index + 1 }}">{{ $month }}</option>
                @endforeach
            </select>
        </div>
    </div>
@endif