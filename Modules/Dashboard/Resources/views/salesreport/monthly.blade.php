<?php 
    $user = Auth::user();
    $api_token = $user->api_token;
?>
@extends('layouts.admin')
@section('page_title', 'Monthly Sales')
@section('styles')
<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="page-heading">
   <h1 class="page-title"> Monthly Sales</h1>
</div>

<div class="page-content fade-in-up">
   <div class="ibox">
      <div class="ibox-body">
         <canvas id="myChart"></canvas>
      </div>
   </div>

</div>


</div>

@endsection

@push('push_scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>
   var monthlySales = <?php echo json_encode($dailySales);?>;
   //console.log(monthlySales['months']);
   var ctx = document.getElementById('myChart').getContext('2d');
   var chart = new Chart(ctx, {
       // The type of chart we want to create
       type: 'line',

       // The data for our dataset
       data: {
           labels: monthlySales['months'],
           datasets: [{
               label: 'sales',
               backgroundColor: 'rgb(255, 99, 132)',
               borderColor: 'rgb(255, 99, 132)',
               data: monthlySales['total_amount'],
           }]
       },

       // Configuration options go here
       options: {}
   });

</script>

@endpush