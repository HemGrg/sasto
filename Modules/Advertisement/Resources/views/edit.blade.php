<?php 
    $user = Auth::user();
    $api_token = $user->api_token;
?>
@extends('layouts.admin')
@section('page_title') Edit Advertisement @endsection

@section('content')

<div class="page-heading">
    <h1 class="page-title"> Advertisement</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href=""><i class="la la-home font-20"></i> Home</a>
        </li>
        <li class="breadcrumb-item"> Edit Advertisement</li>
    </ol>

</div>
@include('admin.section.notifications')

<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">Edit Advertisement</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('advertisement.index')}}">All Advertisement List</a>
            </div>
        </div>
    </div>
    <div class="ibox-body" id="validation-errors" >
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </div>

    <form id="advertise_edit_form">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-12">
                        <div class="ibox">
                            <div class="ibox-head">
                                <div class="ibox-title">Advertise Information</div>
                            </div>
                            <div class="ibox-body">

                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label>Advertise Title</label>
                                        <input class="form-control" type="text"  id="title" name="title"
                                            placeholder="Advertise Title Here">
                                        
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label>URL</label>
                                        <input class="form-control" type="text" value="{{old('link')}}" id="link" name="link"
                                            placeholder="Advertise link here">
                                        
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <label>Position</label>
                                    <select name="ad_position" class="position form-control">
                                        <option value="1">1st row</option>
                                        <option value="2">2nd row</option>
                                        <option value="3">3rd row</option>
                                    </select>
                                </div> -->
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-3">
                        <div class="ibox">
                            <div class="ibox-body">
                                <div class="form-group">
                                    <label> Upload Banner <br><span class="image_dimension">( 360px * 270px )</span>
                                    </label>
                                    <input class="form-control-file" type="file" name="image" id="fileUpload"
                                        accept="image/*">

                                    <div id=" wrapper" class="mt-2">
                                        <div id="image-holder">
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="form-group">
                                    <label>Status:</label>
                                    <select class="form-control custom-select" name="status" id="status">
                                        <option value="Publish">
                                            Publish</option>
                                        <option value="Unpublish">
                                            Unpublish</option>
                                    </select>
                                </div>
                                <div
                                    class="form-group">
                                    <button class="btn btn-success" type="submit"> <span class="fa fa-send"></span>
                                        Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>

@endsection
@section('scripts')
<script>
    $(document).ready(function() {

$("#fileUpload").on('change', function () {

  if (typeof (FileReader) != "undefined") {

   var image_holder = $("#image-holder");

   // $("#image-holder").siblings().remove();

   $("#image-holder").children().remove();

   var reader = new FileReader();
   reader.onload = function (e) {

       $("<img />", {
           "src": e.target.result,
           "class": "thumb-image",
           "width" : '50%'
       }).appendTo(image_holder);

   }
   image_holder.show();
   reader.readAsDataURL($(this)[0].files[0]);
} else {
   alert("This browser does not support FileReader.");
}
});

});

</script>

@endsection

@push('push_scripts')
<script>
$(document).ready(function (e) {
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#advertise_edit_form').submit(function(e) {
        var id = "<?php echo $id; ?>";
        var api_token = '<?php echo $api_token; ?>';

        e.preventDefault();
  
  var formData = new FormData(this);
  formData.append('id', id);
  $.ajax({
        type:'POST',
        url: "/api/updateadvertisement",
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
              window.location.href = "/admin/advertisement";
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
<script> 
 $(document).ready(function(){
     var id = <?php echo $id; ?>;
     var api_token = '<?php echo $api_token; ?>';

            function editadvertisement(id){
                $.ajax({ 
           type: "get", 
		//   url: url,

           url:"/api/editadvertisement", 
           data:{id:id},
           headers: {
            Authorization: "Bearer " + api_token
        },
           success: function(response) {
          $('#name').append(response.data.name).val();
               console.log(response.data.publish)
               document.getElementById('title').value = response.data.title;
               document.getElementById('status').value = response.data.status;
               document.getElementById('link').value = response.data.link;
                document.getElementById('image-holder').innerHTML = '<img width="150" height="150" src="<?php echo URL::to('/').'/images/thumbnail/'; ?>'+response.data.image+'">';        

        //    location.reload();
           }
       });
            }
            editadvertisement(id);
          });
 

</script>
@endpush