<?php 
    $user = Auth::user();
    $api_token = $user->api_token;
?>
@extends('layouts.admin')
@section('page_title', 'Add user')
@section('content')

<div class="page-content fade-in-up">
  <div class="row">
    <div class="col-md-12">
      <div class="ibox">
        <div class="ibox-head">
          <div class="ibox-title">Create user</div>

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

        <div class="ibox-body" style="">
          <form id="user-create-form">
            @csrf
            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                  <label>Full Name</label>
                  <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}"
                    placeholder="Enter full name">
                </div>

                <div class="form-group">
                  <label>Email</label>
                  <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}"
                    placeholder="Enter email">
                </div>

                <div class="form-group">
                  <label>Password</label>
                  <input type="password" class="form-control" id="password" name="password" value="{{old('password')}}"
                    placeholder="Enter Password">
                </div>

                <div class="form-group">
                  <label>Re-Password</label>
                    <div class="d-flex">
                        <input type="password" class="form-control show__password"
                        id="confirm_password" name="confirm_password" value="{{ old('confirm_password') }}"
                            placeholder="Enter Password">
                    </div>
                </div>

                <div class="form-group">
                  <label>Phone</label>
                  <input type="text" class="form-control" id="phone_num" name="phone_num" value="{{old('phone_num')}}"
                    placeholder="Enter Phone">
                </div>

                {{-- <div class="form-group">
                  <label>Image</label>
                  <input id="fileUpload" class="form-control" value="{{old('image')}}" name="image" type="file">
                <div id="wrapper" class="mt-2">
                  <div id="image-holder">
                  </div>
                </div>
              </div> --}}

              <!-- <div class="check-list">
              <label class="ui-checkbox ui-checkbox-primary">
                <input name="published" id="publish" type="checkbox">
                <span class="input-span"></span>Publish</label>
              </div> -->
              <div class="form-group">
                <label>Publish:</label>
                <select class="form-control" id="publish" name="publish">
                  <option value="1">Publish</option>
                  <option value="0">Unpublish</option>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="ibox">
                <div class="ibox-head">
                  <div class="ibox-title">Role</div>
                  <div class="ibox-tools">
                  </div>
                </div>
                <div class="ibox-body" style="">
                  @if(isset($access_levels) && count($access_levels))
                  @foreach($access_levels as $key => $option)
                  <div class="check-list mb-3">
                    <label class="ui-checkbox ui-checkbox-primary">
                      <input type="checkbox" value={{ $key }} name="access[]" id="access">
                      <span class="input-span"></span>{{ $option }}
                    </label>
                  </div>
                  @endforeach
                  @endif

                </div>
              </div>
            </div>
        </div>
        <br>

        <div class="form-group">
        <button type="button" id="submitUser" name="submit" class="btn btn-success ">Submit</button>
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

	$('#submitUser').on('click', function(){
     var name = $('#name').val();
     var email = $('#email').val();
     var password = $('#password').val();
     var confirm_password = $('#confirm_password').val();
     var phone_num = $('#phone_num').val();
     var publish = $('#publish').val();
     var api_token = '<?php echo $api_token; ?>';

     let access = [];
		$(':checkbox:checked').each(function(i){
			access[i] = $(this).val();
        });
    //  var access = $('#access').val();
    //  console.log(access)
     
     $.ajax({
          url: "/api/createuser",
          type:"POST",
          data:{
            "_token": "{{ csrf_token() }}",
            name:name,
            email:email,
            phone_num:phone_num,
            password:password,
            confirm_password:confirm_password,
            publish:publish,
            access:access
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
          window.location.href = "/admin/user";
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