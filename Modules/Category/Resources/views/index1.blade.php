@extends('layouts.admin')
@section('page_title') All Categories @endsection
@section('styles')

<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
@endsection
@section('content')

<div class="page-heading">
    <h1 class="page-title"> Categories</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#"><i class="la la-home font-20"></i> Dashboard</a>
        </li>
        <li class="breadcrumb-item"> All Categories</li>
    </ol>
    @include('admin.section.notifications')
</div>
<div class="ibox-body" id="validation-errors" >
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All Categories</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('category.create')}}">Add Category</a>
            </div>
        </div>

        <div class="ibox-body" id="validation-errors" >
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </div>
        <div class="ibox-body" id="appendCategory">
            
        </div>
    </div>

</div>


@endsection
@section('scripts')
<script src="{{asset('/assets/admin/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/js/sweetalert.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/js/jquery-ui.js')}}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(function() {
        $('#example-table').DataTable({
            pageLength: 2,
        });
    })
    $("#sortable").sortable({
              stop: function(){
                $.map($(this).find('tr'), function(el) {
                  var itemID = el.id;
                  var itemIndex = $(el).index();
                  $.ajax({
                    url:"",
                    method:"post",
                     data: {itemID:itemID, itemIndex: itemIndex},
                    success:function(data){

                    }
                  })
                });
              }
            });
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

    function categories(){
        
        $.ajax({
		  type:'GET',
		  url:'/api/allcategories',
		  
		  success:function(response) {
			$('#appendCategory').html(response.html)
		  },
		  error: function(error) {
			$('#notification-bar').text('An error occurred');
		}
	   });
    }

    categories()
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function deleteCategory(id) {
        alert("Are you sure you want to delete??");
            $.ajax({ 
           type: "post", 
           url:"{{route('api.deletecategory')}}", 
           data:{id:id},
           success: function(response) {
               console.log(response.message)
               var validation_errors = JSON.stringify(response.message);
            $('#validation-errors').html('');
            $('#validation-errors').append('<div class="alert alert-success">'+validation_errors+'</div');
            window.location.href = "/admin/category";
           }
       }); 
          } 

  </script>
@endsection