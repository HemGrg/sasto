<?php 
    $user = Auth::user();
    $api_token = $user->api_token;
?>
@extends('layouts.admin')
@section('page_title') All Product Attribute @endsection
@section('styles')

<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
@endsection
@section('content')


<div class="page-heading">
    <h1 class="page-title"> Product Attribute</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#"><i class="la la-home font-20"></i> Dashboard</a>
        </li>
        <li class="breadcrumb-item"> All Product Attribute</li>
    </ol>
    @include('admin.section.notifications')
</div>
<div class="ibox-body" id="validation-errors" >
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All Product Attribute</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('productattribute.create')}}">Create Product Attribute</a>
            </div>
        </div>

        <div class="ibox-body" id="validation-errors" >
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </div>
        <div class="ibox-body" id="appendattribute">
            
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
       
    });

    $(function () {
        $("#example1").DataTable();
    });

    function attributes(){
        var api_token = '<?php echo $api_token; ?>';
        $.ajax({
		  type:'GET',
		  url:'/api/getproductattribute',
		  headers: {
            Authorization: "Bearer " + api_token
        },
		  success:function(response) {
              console.log(response)
			$('#appendattribute').html(response.html)
		  },
		  error: function(error) {
			$('#notification-bar').text('An error occurred');
		}
	   });
    }

    attributes()
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function deleteBrand(id) {
        var api_token = '<?php echo $api_token; ?>';
        alert("Are you sure you want to delete??");
        // debugger
        console.log(id)
            $.ajax({ 
           type: "post", 

           url:"{{route('api.deletebrand')}}", 
           data:{id:id},
           headers: {
            Authorization: "Bearer " + api_token
        },
           success: function(response) {
               console.log(response.message)
               var validation_errors = JSON.stringify(response.message);
            $('#validation-errors').html('');
            $('#validation-errors').append('<div class="alert alert-success">'+validation_errors+'</div');
            window.location.href = "/admin/brand";
           }
       }); 
          } 

  </script>
  <script>
$(document).ready(function(){
    
    $(".view").click(function() {
        var api_token = '<?php echo $api_token; ?>';
        debugger
        id=$(this).data('id');
        $.ajax({
            method:"post",
            url:"/api/viewrole",
            data:{id:id},
            headers: {
            Authorization: "Bearer " + api_token
        },
            success:function(data){
                console.log(data);
                $('#myModal .modal-body').html(data);
                $('#myModal').modal('show');
            }
        });
    });
});
</script>
@endsection