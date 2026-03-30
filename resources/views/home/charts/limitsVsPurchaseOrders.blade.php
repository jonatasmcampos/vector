<!DOCTYPE HTML>
<html>

<head>
    <script>

        let limitVsPurchaseOrdersChart;

        $(document).ready(function(){
            loadLimitVsPurchaseOrdersChart();
             $('#select_reference_month, #select_reference_year, #select_contract, #select_usage_type')
            .on('change', function () {
                loadLimitVsPurchaseOrdersChart();
            });
        })

        function renderLimitVsPurchaseOrdersChart(data) {
            CanvasJS.addCultureInfo("pt-br", {
                decimalSeparator: ",",
                digitGroupSeparator: ".",
                days: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"],
                shortDays: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
                months: [
                    "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
                    "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"
                ],
                shortMonths: [
                    "Jan", "Fev", "Mar", "Abr", "Mai", "Jun",
                    "Jul", "Ago", "Set", "Out", "Nov", "Dez"
                ]
            });

            limitVsPurchaseOrdersChart = new CanvasJS.Chart("chartContainer", {
                culture: 'pt-br',
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "Visão mensal - Compras x Limites"
                },
                axisX: {
                    valueFormatString: "MMM",
                    interval: 1,
                    intervalType: "month"
                },
                axisY: {
                    prefix: "R$",
                    labelFormatter: addSymbols
                },
                toolTip: {
                    shared: true
                },
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries
                },
                data: [
                    {
                        type: "column",
                        name: "Compras",
                        showInLegend: true,
                        xValueFormatString: "MMMM YYYY",
                        yValueFormatString: "R$#,##0",
                        dataPoints: data.purchase_orders
                    },
                    {
                        type: "line",
                        name: "Limites",
                        showInLegend: true,
                        yValueFormatString: "R$#,##0",
                        dataPoints: data.limits
                    }
                ]
            });
            limitVsPurchaseOrdersChart.render();
        }

        function addSymbols(e) {
            var suffixes = ["", "K", "M", "B"];
            var order = Math.max(Math.floor(Math.log(Math.abs(e.value)) / Math.log(1000)), 0);

            if (order > suffixes.length - 1)
                order = suffixes.length - 1;

            var suffix = suffixes[order];
            return CanvasJS.formatNumber(e.value / Math.pow(1000, order)) + suffix;
        }

        function toggleDataSeries(e) {
            if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
            } else {
                e.dataSeries.visible = true;
            }
            e.chart.render();
        }

        async function loadLimitVsPurchaseOrdersChart() {
            const MONTH = $('#select_reference_month').val();
            const YEAR = $('#select_reference_year').val();
            const CONTRACT_ID = $('#select_contract').val();
            const CREDIT_USAGE_TYPE_ID = $('#select_usage_type').val();

            fetchData(
                    @json(route('view.home.load.chart.limit-vs-purchaseorder')), {
                        month: MONTH,
                        year: YEAR,
                        contract_id: CONTRACT_ID,
                        credit_usage_type_id: CREDIT_USAGE_TYPE_ID
                    }
                )
                .done(function(response) {
                    const data = formatPurchaseVsBudgetData(response);
                    if((!response.purchase_orders || response.purchase_orders.length === 0) || (!response.limits || response.limits.length === 0)){
                        $('#chartContainer').hide();
                        return;
                    }
                    $('#chartContainer').show();
                    renderLimitVsPurchaseOrdersChart(data);
                })
                .fail(function() {
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

        function formatPurchaseVsBudgetData(response) {
            return {
                purchase_orders: response.purchase_orders.map(item => ({
                    x: new Date(item.year, item.month - 1),
                    y: item.value
                })),
                limits: response.limits.map(item => ({
                    x: new Date(item.year, item.month - 1),
                    y: item.value
                }))
            };
        }
    </script>
</head>

<body>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>

</html>
