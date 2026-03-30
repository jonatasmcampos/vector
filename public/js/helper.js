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

function prepareColumnsForYajra(columns) {
    return columns.map(column => ({
        data: column[0],
        name: column[0],
        title: column[1],
        orderable: column[2] ?? true,  
        searchable: column[3] ?? true
    }));
}

function buildYajra(tableId, columns, ajaxUrl, extraAjaxData) {

    const table = $(`#${tableId}`).DataTable({
        processing: true,
        serverSide: true,
        order: [[0, 'desc']],

        ajax: {
            url: ajaxUrl,
            type: "GET",
            data: function (request) {

                // Collect column filters
                $(`#${tableId} thead tr:eq(1) th`).each((index, th) => {
                    const input = $(th).find('input');
                    if (input.length && input.val()) {
                        request.columns[index].search.value = input.val();
                    }
                });

                request.extraAjaxData = extraAjaxData;
            },
            error: function () {
                toastr.warning('Erro ao carregar os dados. Tente novamente', 'error');
            }
        },

        columns: columns,

        language: {
            searchPlaceholder: "Pesquisa",
            sEmptyTable: "Nenhum registro encontrado",
            sInfo: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            sInfoEmpty: "Mostrando 0 até 0 de 0 registros",
            sInfoFiltered: "(Filtrados de _MAX_ registros)",
            sLengthMenu: "_MENU_ resultados por página",
            sLoadingRecords: "Carregando...",
            sProcessing: "Processando...",
            sZeroRecords: "Nenhum registro encontrado",
            sSearch: "Pesquisar",
            oPaginate: {
                sNext: "Próximo",
                sPrevious: "Anterior",
                sFirst: "Primeiro",
                sLast: "Último"
            }
        },

        initComplete: function () {
            const api = this.api();
            const $thead = $(`#${tableId} thead`);
            const $filterRow = $('<tr role="row"></tr>').appendTo($thead);

            // Create filter inputs
            columns.forEach((column, index) => {
                const $th = $('<th></th>').appendTo($filterRow);

                if (column.searchable !== false) {
                    const input = $(`<input type="text" placeholder="Filtrar ${column.title}" class="form-control">`)
                        .appendTo($th)
                        .on('keyup', debounce(() => {

                            const currentSearch = api.column(index).search();
                            const newValue = input.val();

                            if (newValue !== currentSearch || (newValue === '' && currentSearch === '')) {
                                api.ajax.reload();
                            }

                        }, 1000));
                } else {
                    $th.html('');
                }
            });
        }
    });

    // Generic debounce
    function debounce(fn, delay) {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => fn.apply(this, args), delay);
        };
    }

    // Override global search debounce
    $(`#${tableId}_filter input`)
        .off()
        .on('keyup', debounce(function (event) {

            const value = $(event.target).val();

            if (table) {
                table.settings()[0].oPreviousSearch.sSearch = value;
                table.ajax.reload();
            }

        }, 1000));
}
