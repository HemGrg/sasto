<?php 
    $user = Auth::user();
    $api_token = $user->api_token;
?>
@extends('layouts.admin')
@section('page_title') All Orders @endsection
@section('styles')

<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
@endsection
@section('content')

<div class="page-heading">
    <h1 class="page-title"> Orders</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href=""><i class="la la-home font-20"></i> Dashboard</a>
        </li>
        <li class="breadcrumb-item"> All Orders</li>
    </ol>
    @include('admin.section.notifications')
</div>

<div class="page-content fade-in-up">

    <!-- <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">Filter Order</div>
        </div>
        <div class="ibox-body">
            <form action="" method="GET">
                @csrf
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label>Filter By: </label>
                            <select name="filter_by" class="form-control">
                                <option {{ @$filterBy == 'yesterday' ? 'selected' : '' }} value="yesterday">Yesterday
                                </option>
                                <option {{ @$filterBy == 'today' ? 'selected' : '' }} value="today">Today</option>
                                <option {{ @$filterBy == 'week' ? 'selected' : '' }} value="week">7 Days</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 mt-3">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </div>

            </form>
        </div>
    </div> -->

    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All Orders</div>
            <div>{{--
                <a href="{{route('category-order')}}" class="btn btn-info btn-md">Ordering</a>
                <a class="btn btn-info btn-md" href="{{route('category.create')}}">New Category</a>
                --}}
            </div>
        </div>


        <div class="ibox-body" id="appendOrder">
            
        </div>
    </div>

</div>

@endsection
@section('scripts')
<script src="{{asset('/assets/admin/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/js/sweetalert.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $('#example-table').DataTable({
            pageLength: 25,
        });
    })
</script>
<script>
    function FailedResponseFromDatabase(message){
    html_error = "";
    $.each(message, function(index, message){
        html_error += '<p class ="error_message text-left"> <span class="fa fa-times"></span> '+message+ '</p>';
    });
    Swal.fire({
        type: 'error',
        title: 'Oops...',
        html:html_error ,
        confirmButtonText: 'Close',
        timer: 10000
    });
}
function DataSuccessInDatabase(message){
    Swal.fire({
        // position: 'top-end',
        type: 'success',
        title: 'Done',
        html: message ,
        confirmButtonText: 'Close',
        timer: 10000
    });
}
</script>
<script src="{{asset('/assets/admin/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/js/sweetalert.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $('#example-table').DataTable({
            pageLength: 25,
        });
    })
</script>

<script >
  	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function(){
       $('.message').fadeOut(3000);
       $('.delete').submit(function(e){
        e.preventDefault();
        var message=confirm('Are you sure to delete');
        if(message){
          this.submit();
        }
        return;
       });

       
        $('body').on('click', '.changeStatus' ,function(e){
            var api_token = '<?php echo $api_token; ?>';
            e.preventDefault();
            
            var order_id = $(this).data('order_id');
            var status = $(this).data('status');
            $.ajax({
                url:'/api/changeOrderStatus',
                method:"POST",
                data:{
                    order_id : order_id,
                    status : $(this).data('status'),
                    _token: "{{csrf_token()}}"
                },
                headers: {
            Authorization: "Bearer " + api_token
        },
                success : function(response){
                    if (response.status == false ) {
                        FailedResponseFromDatabase(response.message);
                    }
                    if (response.status == true) {
                        
                        $('#appendOrder').empty();
                        $('#appendOrder').html(response.html);

                        DataSuccessInDatabase(response.message);
                        console.log(response.data)
                        

                        // var update_data = response.data[0];
                        // var replace_html = '<span class="btn btn-rounded btn-sm btn-'+((update_data.status == 'Verified')? 'success' : 'warning')+' changeStatus" data-status="'+update_data.status+'" data-order_id = "'+update_data.id+'" style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title= "Make '+((update_data.status == 'Publish')? 'Unpublish' : 'Publish')+' this Category.">'+update_data.status+'ed</span>';
                        // $('.changeStatus'+order_id).html(replace_html);


                    }
                }
            })
        })
    
       
       
    });

    $(function () {
        $("#example1").DataTable();
    });

    function orders(){
        var api_token = '<?php echo $api_token; ?>';
        $.ajax({
		  type:'GET',
		  url:'/api/getorders',
		  headers: {
            Authorization: "Bearer " + api_token
        },
		  success:function(response) {
			$('#appendOrder').html(response.html)
		  },
		  error: function(error) {
			$('#notification-bar').text('An error occurred');
		}
	   });
    }

    orders()
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    

  </script>

@endsection