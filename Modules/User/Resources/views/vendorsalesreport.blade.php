<?php 
    $user = Auth::user();
    $api_token = $user->api_token;
?>
@extends('layouts.admin')
@section('page_title', 'Daily Sales')
@section('styles')
<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="page-heading">
   <h1 class="page-title"> Custom Date</h1>
</div>
<div class="page-content fade-in-up">
   <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title"> Vendor Report
            </div>
        <div>
    </div>

   </div>
</div>
<div class="box">
       
<div class="page-content fade-in-up">
   <div class="ibox">
      <div class="ibox-body">
         <canvas id="myChart"></canvas>
                Total Sales Amount:: Rs. <input type="text" id="total_amt" value="{{$total_sales}}" disabled>
      </div>
   </div>
</div>


</div>

@endsection

@push('push_scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
   var months_day = <?php echo json_encode($months_day); ?>;
   var dailySales = <?php echo json_encode($amt);?>;
   var ctx = document.getElementById('myChart').getContext('2d');
   var chart = new Chart(ctx, {
       // The type of chart we want to create
       type: 'line',
       // The data for our dataset
       data: {
           labels: months_day,
           datasets: [{
               label: 'sales',
            //    backgroundColor: 'rgb(255, 99, 132)',
               borderColor: 'rgb(255, 99, 132)',
               data: dailySales,
           }]
       },

       // Configuration options go here
       options: {
         scales:
            {
                yAxes:
                [{
                    ticks: {
                        beginAtZero: !0
                    }
                }] ,
                xAxes: [{
                        stacked: false,
                        beginAtZero: true,
                        scaleLabel: {
                            labelString: 'Month'
                        },
                        ticks: {
                            stepSize: 1,
                            min: 0,
                            autoSkip: false
                        }
                    }]
            }
       }
   });

</script>


@endpush