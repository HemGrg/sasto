<?php 
    $user = Auth::user();
    $api_token = $user->api_token;
?>
@extends('layouts.admin')
@section('content')

<div class="page-content fade-in-up">
  <div class="row">
    <div class="col-md-12">
      <div class="ibox">
        <div class="ibox-head">
          <div class="ibox-title">Create Role</div>

          <div class="ibox-tools">

          </div>
        </div>
        @if (count($errors) > 0)
        <div class="alert alert-danger">
          <ul>
            @foreach($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
          </ul>
        </div>
        @endif
        
    <div class="ibox-body" id="validation-errors" >
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </div>

        <div class="ibox-body" style="">
          <form>
            <div class="form-group">
              <label>Name</label>
              <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}" placeholder="Enter name">
            </div>

            <!-- <div class="form-group">
              <label>Slug</label>
              <input type="text" class="form-control" id="slug" name="slug" value="{{old('slug')}}" placeholder="Enter slug">
            </div> -->

            <div class="check-list">
              <label class="ui-checkbox ui-checkbox-primary">
                <input name="publish" id="publish" type="checkbox">
                <span class="input-span"></span>Publish</label>
            </div>

            <br>

            <div class="form-group">
            <button type="button" id="submitRole" name="submit" class="btn btn-success ">Submit</button>
            <!-- <input  type="button" name="save" value="save" id="submitRole" class="btn btn-success"> -->
            <!-- <button class="btn btn-success" id="submitRole" >submit</button> -->
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
<script>
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

	$('#submitRole').on('click', function(){
    var api_token = '<?php echo $api_token; ?>';
     var name = $('#name').val();
     var publish = $('#publish').val();
     console.log(publish)
     $.ajax({
          url: "/api/createrole",
          type:"POST",
          data:{
            "_token": "{{ csrf_token() }}",
            name:name,
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
          window.location.href = "/role";
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
        
         function closeModal(id){
		var popup_title = document.getElementById('popup-modal-title').textContent;
		if(popup_title == 'Unauthorized User' || popup_title == 'Successful'){
			window.location.href = '<?php echo URL::to("/")."/admin/role"; ?>';
			exit;
		}
		$('#'+id).modal('toggle');
	}

		
	});
</script>

@endpush


