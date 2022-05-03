<?php 
    $user = Auth::user();
    $api_token = $user->api_token;
?>
@extends('layouts.admin')
@section('page_title', 'Add offer')
@section('content')

<div class="page-content fade-in-up">
  <div class="row">
    <div class="col-md-12">
      <div class="ibox">
        <div class="ibox-head">
          <div class="ibox-title">Create Offer</div>

          <div class="ibox-tools">

          </div>
        </div>
        
    <div class="ibox-body" id="validation-errors" >
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </div>

        <div class="ibox-body" style="">
          <form id="offer-create-form">
          <div class="form-group">
              <label>Title</label>
              <input type="text" class="form-control" name="title" id="title" value="{{old('title')}}" placeholder="Enter title">
            </div>

            <!-- <div class="form-group">
              <label>Slug</label>
              <input type="text" class="form-control" name="slug" id="slug" value="{{old('slug')}}" placeholder="Enter slug">
            </div> -->

            

            <div class="row form-group col-md-6">
            <label>Upload Image </label>
            <input class="form-control"  name="image" type="file" id="fileUpload">
                <div id="wrapper" class="mt-2">
                    <div id="image-holder">
                    </div>
                </div>
          </div>

            <div class="check-list">
              <label class="ui-checkbox ui-checkbox-primary">
                <input name="publish" id="publish" type="checkbox">
                <span class="input-span"></span>Publish</label>
            </div>

            <br>

            <div class="form-group">
            <button type="submit" class="btn btn-success">Submit</button>
            </div>

          </form>
        </div>
      </div>
    </div>

  </div>



</div>

<div class="modal" id="popupModal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
		<div class="modal-header">
        <h3 id="popup-modal-title" class="modal-title"></h5>
      </div>
			<div class="modal-body">
				<div style="text-align: center;" id="popup-modal-body"></div>
			</div>
			<div class="modal-footer">
				<button id="popup-modal-btn" onclick="closeModal('popupModal');" type="button" class="btn">
					OK
				</button>
			</div>
		</div>
	</div>
</div>

@endsection
@push('push_scripts')

@include('dashboard::admin.layouts._partials.imagepreview')

@endpush

@push('push_scripts')
<script>
$(document).ready(function (e) {
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#offer-create-form').submit(function(e) {
      var api_token = '<?php echo $api_token; ?>';
        e.preventDefault();
  
  var formData = new FormData(this);
  $.ajax({
        type:'POST',
        url: "/api/createoffer",
        data: formData,
        enctype: 'multipart/form-data',
        cache:false,
        contentType: false,
        processData: false,
        headers: {
            Authorization: "Bearer " + api_token
        },
        success:function(response){
            console.log(response.data);
            if(response.status == 'successful'){
              window.location.href = "/admin/offer";
              var validation_errors = JSON.stringify(response.message);
                $('#validation-errors').html('');
                $('#validation-errors').append('<div class="alert alert-success">'+validation_errors+'</div');
                }  else if(response.status == 'unsuccessful') {
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
   });


</script>

@endpush


