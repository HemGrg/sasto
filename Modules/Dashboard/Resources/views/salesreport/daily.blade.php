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
         <div>
         <form>
            <label>Start Date</label>
            <input type="date" id="start_date" class="bod-picker " name="start_date" autocomplete="off" value="">
            <label>End Date</label>
            <input type="date" id="end_date" class="bod-picker " name="end_date" autocomplete="off" value="">
            <label for="address">Select Vendor</label>
            <select id="vendor">
                    <i class="fa fa-eye"></i>
                <option value="">Select Vendor</option>
                @foreach($vendors as $vendor)
                <option value="{{$vendor->user_id}}">{{$vendor->shop_name}}</option>
                @endforeach
            </select>
            <input type="button" name="submit" value="Submit" style="margin-top: 5px" class="btn btn-success customDateSearch" formtarget="_blank">
            <a class="btn btn-info btn-md" href="{{route('sales_report')}}">All Report</a> 
        </form>

      </div>

   </div>
</div>
<div class="box">
       
<div class="page-content fade-in-up">
   <div class="ibox">
      <div class="ibox-body">
         <canvas id="myChart"></canvas>
                Total Sales Amount:: Rs. <input type="text" id="total_amt" value="{{$sales}}" disabled>
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
    // $('input[name="start_date"]').daterangepicker();
    // $('input[name="end_date"]').daterangepicker();
    $('.customDateSearch').click(function(){
      var start_date = $('#start_date').val()
      var end_date = $('#end_date').val()
      var vendor = $('#vendor').val()
      var api_token = '<?php echo $api_token; ?>';
      $.ajax({
          method:'post',
          url:'/api/salesSearchByDates',
          data:{start_date:start_date, end_date:end_date, vendor:vendor},
          headers: {
            Authorization: "Bearer " + api_token
        },
          success:function(response){
            console.log(response)
            document.getElementById('total_amt').value = '';
            document.getElementById('total_amt').value = response.total_sales;
            var months_day = response.months_day;
   var dailySales = response.sales;
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

          }
        });
    })
$(document).ready(function(){
      $('#month').on('change',function(){
        value=$(this).val();
        console.log(value)
        $.ajax({
          method:'post',
          url:"",
          data:{value:value},
          success:function(data){
          }
        });
      });
    });
</script>
<script>
   var months_day = <?php echo json_encode($months_day); ?>;
   var dailySales = <?php echo json_encode($dailySales);?>;
   var ctx = document.getElementById('myChart').getContext('2d');
   var chart = new Chart(ctx, {
       // The type of chart we want to create
       type: 'line',
       // The data for our dataset
       data: {
           labels: months_day['date'],
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