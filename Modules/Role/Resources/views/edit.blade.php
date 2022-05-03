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
            <button type="button" id="updateRole" name="submit" class="btn btn-success ">Submit</button>
            <!-- <input  type="button" name="save" value="save" id="submitRole" class="btn btn-success"> -->
            <!-- <button class="btn btn-success" id="submitRole" >submit</button> -->
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
    
    $('#updateRole').on('click', function(){
      var api_token = '<?php echo $api_token; ?>';
      var id = <?php echo $id; ?>;
      var name = $('#name').val();
     var publish = $('#publish').val();
     console.log(name)
     console.log(publish)
     $.ajax({
      url: "/api/updaterole",
          type:"POST",
          data:{
            "_token": "{{ csrf_token() }}",
            id:id,
            name:name,
            publish:publish,
          },
          headers: {
            Authorization: "Bearer " + api_token
        },
          success:function(response){
            console.log(response.data)
            window.location.href = "/role";
            if(response.status == 'successful') {
              window.location.href = "/role";
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
            function editrole(id){
                $.ajax({ 
           type: "get", 
		//   url: url,

           url:"/api/editrole", 
           data:{id:id},
           headers: {
            Authorization: "Bearer " + api_token
        },
           success: function(response) {
          $('#name').append(response.data.name).val();
               console.log(response.data.publish)
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
            editrole(id);
          });
 

</script>

@endpush


