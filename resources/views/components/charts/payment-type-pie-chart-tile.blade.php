<div class="card z-depth-0">
    <div class="card-header bg-light">
        <div class="d-flex align-items-center">
            <div class="card-title">Sales by Payment Methods</div>
        </div>
    </div>
    <div class="card-body">
        <div id="payment-type-pie-chart" style="height: 300px;"></div>
    </div>
</div>

@push('push_scripts')
<script>
     new Chartisan({
        el: '#payment-type-pie-chart'
        , url: "@chart('payment_type_pie_chart')"
        , hooks: new ChartisanHooks()
            .beginAtZero(false)
            .pieColors(['#f60027', '#5db544', '#262f4e'])
            .responsive()
            .legend({
                position: 'bottom'
            })
            .datasets('doughnut')
     });

    // Refetch data on form submit
    // document.getElementById('earnings-query-form').addEventListener('submit', function(event) {
    //     event.preventDefault();
    //     let params = new URLSearchParams(Array.from(new FormData(event.srcElement))).toString();
    //     earningsChart.update({
    //         url: earningsChartUrl + '?' + params
    //     });
    //     return false;
    // });

</script>
@endpush