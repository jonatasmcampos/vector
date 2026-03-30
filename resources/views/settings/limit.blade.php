<h5 class="fw-semibold mb-3">Limites de crédito</h5>

<form id="period-type-settings-form" class="row g-3">
    @csrf
    @foreach ($data->credit_usage_types as $credit_usage_type_id => $credit_usage_type)
        @php
            $key = strtolower($credit_usage_type['name']);
            $settingKey = "limit.$key-period-type";
            $current = $data->credit_limit_periods[$settingKey] ?? 'monthly';
        @endphp

        <div class="col-md-12">
            <label class="form-label fw-semibold">
                {{ $credit_usage_type['description'] }}
            </label>

            <div class="d-flex gap-4 mt-1">
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="settings[{{ $settingKey }}]"
                        value="monthly"
                        @checked($current === 'monthly')
                    >
                    <label class="form-check-label">
                        Mensal
                    </label>
                </div>

                {{-- <div class="form-check">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="settings[{{ $settingKey }}]"
                        value="rotative"
                        @checked($current === 'rotative')
                    >
                    <label class="form-check-label">
                        Rotativo
                    </label>
                </div> --}}
            </div>
        </div>
    @endforeach
    <div class="text-end mt-4">
        <button 
            id="period-type-settings-save-button" 
            type="submit" 
            class="btn btn-dark"
            disabled
        >
            <i class="bi bi-floppy"></i> &nbsp; Salvar
        </button>
    </div>
</form>
@push('scripts')
    <script>
        $('#period-type-settings-form').on('submit', function (e) {
            e.preventDefault();

            const buttonId = 'period-type-settings-save-button';
            disableButton(buttonId);

            const form = $(this);

            $.ajax({
                url: "{{ route('settings.settings.define-period-for-usage.store') }}",
                method: "POST",
                data: form.serialize(),
                dataType: "json",

                success: function (response) {
                    toastr.success(response.message);
                },

                error: function (xhr) {
                    let message = xhr.responseJSON?.message ?? 'Erro inesperado';
                    toastr.error(message);
                },

                complete: function () {
                    enableButton(buttonId);
                }
            });
        });
    </script>
@endpush