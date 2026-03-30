<h5 class="fw-semibold">Validação de saldos</h5>

<div class="text-muted mb-3">
    Define regras de validação referente às transações.
</div>

<form id="balance-validation-form">
    @csrf

    <div class="form-check form-switch">
        <input 
            class="form-check-input"
            type="checkbox"
            name="settings[validate-balance.purchase-order-payment-on-acquisition]"
            value="1"
            @checked(
                $data->balance_validation_group['validate-balance.purchase-order-payment-on-acquisition'] ?? false
            )
        >
        <label class="form-check-label">
            Validar saldo para pagamento na aquisição
        </label>
    </div>

    <div class="text-end mt-4">
        <button 
            id="balance-validation-save-button" 
            type="submit" 
            class="btn btn-dark"
        >
            <i class="bi bi-floppy"></i> &nbsp; Salvar
        </button>
    </div>
</form>


@push('scripts')
    <script>
        $('#balance-validation-form').on('submit', function (e) {
            e.preventDefault();

            const buttonId = 'balance-validation-save-button';
            disableButton(buttonId);

            const form = $(this);

            $.ajax({
                url: "{{ route('settings.settings.validate-balance.store') }}",
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
