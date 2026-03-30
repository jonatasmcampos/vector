<div id="not-empty-state" class="card border-0 p-4">

    <!-- ================= HEALTH ================= -->
    <div id="budget-health-card">
        <div class="d-flex align-items-center">
            <h4 class="mb-0 me-2">Saúde do orçamento</h4>
            <span id="budget-status" class="status gray">Loading...</span>
        </div>

        <div class="mt-2">
            <strong id="health-headline">—</strong>
            <div id="health-message" class="text-muted"></div>
        </div>

        <div class="card-body">
            <div class="metrics">
                <div class="metric">
                    <label>Consumido</label>
                    <h2 id="consumed-percent">0%</h2>
                </div>

                <div class="metric">
                    <label>Esperado</label>
                    <h2 id="expected-percent">0%</h2>
                </div>

                <div class="metric">
                    <label>Diferença</label>
                    <h2 id="diff-percent">0%</h2>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <!-- ================= PROJECTIONS ================= -->
    <div id="budget-projections-card">

        <h4>Projeção do orçamento</h4>

        <div class="mt-2">
            <strong id="projection-headline">—</strong>
            <div id="projection-message" class="text-muted"></div>
        </div>

        <div class="card-body">
            <div class="metrics">
                <div class="metric">
                    <label>Média diária</label>
                    <h2 id="burn-rate-daily">0</h2>
                </div>

                <div class="metric">
                    <label>Projeção mês</label>
                    <h2 id="projection-percent">0%</h2>
                </div>

                <div class="metric">
                    <label>Restante</label>
                    <h2 id="remaining">0</h2>
                </div>
            </div>

            <div class="footer">
                <span id="remaining-daily">0</span> por dia disponível até o fim do mês
            </div>
        </div>
    </div>
</div>

<style>
   .card {
    background: #ffffff;
    border-radius: 14px;
    padding: 18px;
    box-shadow: 0 6px 24px rgba(15, 23, 42, 0.06);
    border: 1px solid #f1f5f9;
}

/* ================= STATUS ================= */

.status {
    padding: 5px 12px;
    border-radius: 999px;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

/* verde mais suave */
.status.green {
    background: #ecfdf5;
    color: #047857;
    border: 1px solid #a7f3d0;
}

/* amarelo mais elegante */
.status.yellow {
    background: #fffbeb;
    color: #92400e;
    border: 1px solid #fde68a;
}

/* vermelho menos agressivo */
.status.red {
    background: #fef2f2;
    color: #b91c1c;
    border: 1px solid #fecaca;
}

/* neutro */
.status.gray {
    background: #f8fafc;
    color: #64748b;
    border: 1px solid #e2e8f0;
}

/* ================= TITLES ================= */

h4 {
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 0;
}

/* ================= INSIGHT TEXT ================= */

#health-headline,
#projection-headline {
    color: #0f172a;
    display: block;
    margin-top: 10px;
}

#health-message,
#projection-message {
    color: #64748b;
    margin-top: 2px;
}

/* ================= METRICS ================= */

.metrics {
    display: flex;
    justify-content: space-between;
    margin-top: 14px;
    gap: 10px;
    text-align: center
}

.metric {
    flex: 1;
    background: #f8fafc;
    padding: 10px;
    border-radius: 10px;
    border: 1px solid #eef2f7;
}

.metric label {
    color: #64748b;
}

.metric h2 {
    margin: 4px 0 0 0;
    font-weight: 600;
    color: #0f172a;
}

/* ================= FOOTER ================= */

.footer {
    margin-top: 12px;
    color: #64748b;
}

/* ================= SEPARADOR ================= */

hr {
    border: none;
    height: 1px;
    background: #eef2f7;
    margin: 16px 0;
}
</style>
<script>
    $(document).ready(function() {
        loadBudgetHealth();
        $('#select_reference_month, #select_reference_year, #select_contract, #select_usage_type')
            .on('change', function() {
                loadBudgetHealth();
            });
    });

    async function loadBudgetHealth() {
        const MONTH = $('#select_reference_month').val();
        const YEAR = $('#select_reference_year').val();
        const CONTRACT_ID = $('#select_contract').val();
        const CREDIT_USAGE_TYPE_ID = $('#select_usage_type').val();

        fetchData(
                @json(route('view.home.load.budget-health')), {
                    month: MONTH,
                    year: YEAR,
                    contract_id: CONTRACT_ID,
                    credit_usage_type_id: CREDIT_USAGE_TYPE_ID
                }
            )
            .done(function(response) {

                const health = response.health;
                const projections = response.projections;
                
                // =========================
                // EMPTY STATE CHECK
                // =========================
                const hasData =
                    health &&
                    projections &&
                    (health.consumed_percent !== undefined);

                // mostrar conteúdo
                $('#not-empty-state').show();

                // ================= HEALTH =================
                $('#budget-status')
                    .removeClass('green yellow red gray')
                    .addClass(health.status || 'gray')
                    .text((health.status || 'gray').toUpperCase());

                $('#consumed-percent').text((health.consumed_percent ?? 0) + '%');
                $('#expected-percent').text((health.expected_percent ?? 0) + '%');
                $('#diff-percent').text((health.diff_percent ?? 0) + '%');

                $('#health-headline').text(health.headline || '—');
                $('#health-message').text(health.message || '');

                // ================= PROJECTIONS =================
                $('#burn-rate-daily').text('R$ ' + (projections.burn_rate_daily ?? '0'));
                $('#projection-percent').text((projections.projection_percent ?? 0) + '%');
                $('#remaining').text('R$ ' + (projections.remaining ?? '0'));
                $('#remaining-daily').text('R$ ' + (projections.remaining_daily ?? '0'));

                $('#projection-headline').text(projections.headline || '—');
                $('#projection-message').text(projections.message || '');
            })
            .fail(function() {
                $('#not-empty-state').hide();
                console.error('Erro ao carregar gráfico Purchase vs Budget');
            });
    }

    function fetchData(url, params = {}) {
        return $.ajax({
            url: url,
            method: 'GET',
            data: params,
            dataType: 'json'
        });
    }

</script>
