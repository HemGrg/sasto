@extends('layouts.admin')
@section('page_title') All Admin Users @endsection
@section('content')
<div class="ibox-body" id="validation-errors" >
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All {{ucfirst($role)}}s</div>
        </div>
        <div class="ibox-body" id="validation-errors" >
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </div>
            <div class="px-4">
                <form action="" class="form-inline" method="GET">
                    <input type="text" name="search" class="form-control" value="{{ request()->get('search') }}" placeholder="Search">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        <div class="ibox-body table-responsives-sm" id="appendUser">
        @include('adminuser::usersTable')
        </div>
    </div>

</div>


@endsection
@section('scripts')
<script src="{{asset('/assets/admin/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/js/sweetalert.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    // $(function() {
    //     $('#example-table').DataTable({
    //         pageLength: 25,
    //     });
    // })
</script>

<script >
    function users(){

        $.ajax({
		  type:'GET',
		  url:'/api/getusers',
		  success:function(response) {
			$('#appendUser').html(response.html),
            $('#pagination').html(response['pagination']);
		  },
		  error: function(error) {
			$('#notification-bar').text('An error occurred');
		}
	   });
    }

    // users();

    function deleteUser(el,id) {
        if (!confirm("Are you sure you want to delete?")){
            return false;
        }
            $.ajax({ 
           type: "post", 

           url:"{{route('api.deleteuser')}}", 
           data:{id:id},
           success: function(response) {
               var validation_errors = JSON.stringify(response.message);
            $('#validation-errors').html('');
            $('#validation-errors').append('<div class="alert alert-success">'+validation_errors+'</div');
            $(el).closest('tr').remove()
           }
       }); 
          } 

  </script>
@endsection