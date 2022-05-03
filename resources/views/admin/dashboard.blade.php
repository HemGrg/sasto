@extends('layouts.admin')

@section('page_title') Admin @endsection
@section('content')
<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <a href="{{route('product.index')}}">
                <div class="ibox bg-danger color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong"> {{$allproduct_summary}}</h2>
                        <div class="m-b-5">Total Product </div>
                        <i class="ti-shopping-cart widget-stat-icon"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-6">
            <a href="{{route('user-list')}}">
                <div class="ibox bg-danger color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong"> {{$all_user}}</h2>
                        <div class="m-b-5">All Customer </div>
                        <i class="ti-user widget-stat-icon"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-4 col-md-6">
            <a href="{{route('order-list')}}">
                <div class="ibox bg-danger color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong"> {{$new_order}}</h2>
                        <div class="m-b-5">Total Orders </div>
                        <i class="ti-shopping-cart-full widget-stat-icon"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-6">
            <a href="{{route('advertise.index')}}">
                <div class="ibox bg-danger color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong">{{$all_ad_list}}</h2>
                        <div class="m-b-5">Total Advertise</div><i class="ti-money widget-stat-icon"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-6">
            <a href="{{route('post.index')}}">
                <div class="ibox bg-danger color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong">{{$all_blogs}}</h2>
                        <div class="m-b-5">Total Blogs</div>
                        <i class="ti-files widget-stat-icon"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-6">
            <a href="{{route('message-list')}}">
                <div class="ibox bg-danger color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong">{{$contact_list}}</h2>
                        <div class="m-b-5">Message Box</div>
                        <i class="ti-envelope widget-stat-icon"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-6">
            <a href="{{route('list-subscriber')}}">
                <div class="ibox bg-danger color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong">{{$all_subscriber}}</h2>
                        <div class="m-b-5">Total Subscribers</div>
                        <i class="fa fa-thumbs-up widget-stat-icon"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- Graph Reports --}}
    <div class="ibox">
        <div class="ibox-body">
            <h3>Daily Sales Report</h3>
            <canvas id="dailyChart"></canvas>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="ibox">
                <div class="ibox-body">
                    <h4>Weekly Sales Report</h4>
                    <canvas id="weeklyChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="ibox">
                <div class="ibox-body">
                    <h4>Monthly Sales Report</h4>
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <style>
        .visitors-table tbody tr td:last-child {
            display: flex;
            align-items: center;
        }

        .visitors-table .progress {
            flex: 1;
        }

        .visitors-table .progress-parcent {
            text-align: right;
            margin-left: 10px;
        }
    </style>

</div>
@endsection

@push('push_scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<script>
    // daily report Chart
    var months_day = <?php echo json_encode($daily_reports['months_day']); ?>;
    var dailySales = <?php echo json_encode($daily_reports['dailySales']);?>;
    var ctx = document.getElementById('dailyChart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'bar',
        // The data for our dataset
        data: {
            labels: months_day['date'],
            datasets: [{
                label: 'sales',
                backgroundColor: 'rgb(255, 99, 132)',
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
                 xAxes: [
                     {
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

    // weekly report chart
   var week_days = <?php echo json_encode($weekly_reports['week_days']); ?>;
   var weekly_sales_total = <?php echo json_encode($weekly_reports['weekly_sales_total']); ?>;
   var ctx = document.getElementById('weeklyChart').getContext('2d');
   var chart = new Chart(ctx, {
       // The type of chart we want to create
       type: 'bar',

       // The data for our dataset
       data: {
           labels: week_days['day'],
           datasets: [{
               label: 'sales',
               data: weekly_sales_total,
               backgroundColor: 'rgb(255, 99, 132)',
               borderColor: 'rgb(255, 99, 132)'
           }],
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

   // monthly report chart
   var monthlySales = <?php echo json_encode($monthly_reports['monthlySales']);?>;
   //console.log(monthlySales['months']);
   var ctx = document.getElementById('monthlyChart').getContext('2d');
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
       }
   });

</script>

@endpush