<?php 
    $user = Auth::user();
    $api_token = $user->api_token;
?>
@extends('layouts.admin')
@section('page_title', 'Add brand')
@section('content')


<div class="page-content fade-in-up">
  <div class="row">
    <div class="col-md-12">
      <div class="ibox">
        <div class="ibox-head">
          <div class="ibox-title">Create brand</div>

          <div class="ibox-tools">

          </div>
        </div>
       
        <div class="ibox-body" id="validation-errors" >
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </div>

        <div class="ibox-body" style="">
          <form>
            <div class="form-group">
              <label>Title</label>
              <input type="text" class="form-control" name="title" id="title" value="{{old('title')}}" placeholder="Enter title">
            </div>

            <!-- <div class="form-group">
              <label>Slug</label>
              <input type="text" class="form-control" name="slug" value="{{old('slug')}}" placeholder="Enter slug">
            </div> -->

            <div class="check-list">
              <label class="ui-checkbox ui-checkbox-primary">
                <input name="publish" id="publish" type="checkbox" >
                <span class="input-span"></span>Publish</label>
            </div>

            <br>

            <div class="form-group">
            <button type="button" id="submitBrand" name="submit" class="btn btn-success ">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>



</div>

@endsection

@push('push_scripts')
<script>
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

	$('#submitBrand').on('click', function(){
    var api_token = '<?php echo $api_token; ?>';
     var title = $('#title').val();
     var publish = $('#publish').val();
     console.log(publish)
     $.ajax({
          url: "/api/createbrand",
          type:"POST",
          data:{
            "_token": "{{ csrf_token() }}",
            title:title,
            publish:publish,
          },
          headers: {
            Authorization: "Bearer " + api_token
        },
          success:function(response){
            console.log(response.data);
            if(response.status == 'successful'){
              
          //     var modal_title = "Success";
					// modal_title = modal_title.fontcolor('green');
          // $('#popup-modal-body').append(response.message);
          // $('#popup-modal-title').append(modal_title);
          // $('#popup-modal-btn').addClass('btn-success');
					// $("#popupModal").modal('show');
          window.location.href = "/admin/brand";
          var validation_errors = JSON.stringify(response.message);
            $('#validation-errors').html('');
            $('#validation-errors').append('<div class="alert alert-success">'+validation_errors+'</div');
            } else if(response.status == 'unsuccessful') {
              var validation_errors = JSON.stringify(response.data);
            var response = JSON.parse(validation_errors);
            $('#validation-errors').html('');
            $.each( response, function( key, value) {
            $('#validation-errors').append('<div class="alert alert-danger">'+value+'</div');
        });
            }
          }
         
         });
        
	});
</script>

@endpush