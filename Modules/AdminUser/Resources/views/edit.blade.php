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
          <div class="ibox-title">Edit user</div>

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
          <form method="post" action="" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                  <label>Full Name</label>
                  <input type="text" class="form-control" id="name" name="name" 
                    placeholder="Enter full name">
                </div>

                <div class="form-group">
                  <label>Email</label>
                  <input type="email" class="form-control" id="email" name="email" 
                    placeholder="Enter email">
                </div>

                <div class="form-group">
                  <label>Password</label>
                  <input type="text" class="form-control" id="password" name="password" 
                    placeholder="Enter Password">
                </div>

                <div class="form-group">
                  <label>Phone</label>
                  <input type="text" class="form-control" id="phone" name="phone_num" 
                    placeholder="Enter Phone">
                </div>

                {{-- <div class="form-group">
                  <label>Image</label>
                  <input id="fileUpload" class="form-control" value="{{$detail->image}}" name="image" type="file">
                <br>
                <div id="wrapper" class="mt-2">
                  <div id="image-holder">
                    @if($detail->image)
                    <img src="{{asset('images/main/'.$detail->image)}}" alt="" height="120px" width="120px">
                    @endif
                  </div>
                </div>
              </div> --}}

              <div class="form-group">
                <label>Publish:</label>
                <select class="form-control" id="publish" name="publish">
                  <option  value="1">Publish</option>
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
                      <input type="checkbox" value={{ $key }} id="access-{{$key}}" name="access[]"
                        >
                      <span class="input-span"></span>{{ $option }}</label>
                  </div>
                  @endforeach
                  @endif

                </div>
              </div>
            </div>
        </div>

        <br>

        <div class="form-group">
        <button type="button" id="updateUser" name="submit" class="btn btn-success ">Submit</button>
        </div>
        </form>
      </div>
    </div>
  </div>

</div>



</div>

@endsection
<!-- @push('scripts')
<script> 
 $(document).ready(function(){
     debugger
     var id = <?php echo $id; ?>;
     console.log(id)
            function edituser(id){
                $.ajax({ 
           type: "get", 
		//   url: url,

           url:"/api/edituser", 
           data:{id:id},
           success: function(response) {
          $('#name').append(response.data.name).val();
               console.log(response.data)
               document.getElementById('name').value = response.data.name;
               if (response.data.publish == '1') {
						document.getElementById('publish').checked = true;
					} else {
						document.getElementById('publish').checked = false;
					}
        //    location.reload();
           }
       });
            }
            edituser(id);
          });
 

</script>
@endpush -->
@push('push_scripts')
<script>
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $('#updateUser').on('click', function(){
      var id = <?php echo $id; ?>;
      var name = $('#name').val();
     var email = $('#email').val();
     var password = $('#password').val();
     var confirm_password = $('#confirm_password').val();
     var phone_num = $('#phone').val();
     var publish = $('#publish').val();
     var api_token = '<?php echo $api_token; ?>';

     let access = [];
		$(':checkbox:checked').each(function(i){
			access[i] = $(this).val();
        });
     $.ajax({
      url: "/api/updateuser",
          type:"POST",
          data:{
            "_token": "{{ csrf_token() }}",
            id:id,
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
            console.log(response.data)
            if(response.status == 'successful') {
              window.location.href = "/admin/user";
          var validation_errors = JSON.stringify(response.message);
            $('#validation-errors').html('');
            $('#validation-errors').append('<div class="alert alert-success">'+validation_errors+'</div');
            }
          }
     });

    });

	
</script>
<script> 
 $(document).ready(function(){
     var id = <?php echo $id; ?>;
     var api_token = '<?php echo $api_token; ?>';

            function edituser(id){
                $.ajax({ 
           type: "get", 
		//   url: url,

           url:"/api/edituser", 
           data:{id:id},
           headers: {
            Authorization: "Bearer " + api_token
        },
    
           success: function(response) {
               document.getElementById('name').value = response.data.name;
               document.getElementById('email').value = response.data.email;
               document.getElementById('phone').value = response.data.phone_num;
               document.getElementById('publish').value = response.data.publish;
               
                if(response.data.access_level){
                    let permissions =   JSON.parse(response.data.access_level);
               document.getElementById('access-category').value == permissions;
               for(var i=0;i<=permissions.length;i++){
                   if(permissions[i] && permissions[i] == document.getElementById('access-'+permissions[i]).value){
                        document.getElementById('access-'+permissions[i]).checked = true;
                    }    
               }
                } 
               
           }
       });
            }
            edituser(id);
          });
 

</script>

@endpush