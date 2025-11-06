function togglePassword(btnSeePassword, inputPasswordId, seePasswordIcon) {    
    $(`#${btnSeePassword}`).on('click', function () {
        const input = $(`#${inputPasswordId}`);
        const icone = $(`#${seePasswordIcon}`);

        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icone.removeClass('bi-eye').addClass('bi-eye-slash');
        } else {
            input.attr('type', 'password');
            icone.removeClass('bi-eye-slash').addClass('bi-eye');
        }
    });
}

function disableButton(button_id) {
    const btn = $(`#${button_id}`);
    
    if (!btn.data('original-html')) {
        btn.data('original-html', btn.html());
    }

    btn.prop('disabled', true);
    btn.html('<i class="bi bi-arrow-repeat spinning me-2"></i> Processando ...');
}

function enableButton(button_id) {
    const btn = $(`#${button_id}`);
    btn.prop('disabled', false);

    const originalHtml = btn.data('original-html');
    if (originalHtml) {
        btn.html(originalHtml);
    }
}