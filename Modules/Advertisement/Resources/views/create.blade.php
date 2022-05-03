<?php 
    $user = Auth::user();
    $api_token = $user->api_token;
?>
@extends('layouts.admin')
@section('page_title') Add Advertisement @endsection

@section('content')

<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">Add Advertisement</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('advertisement.index')}}">All Advertisement List</a>
            </div>
        </div>
    </div>
    <div class="ibox-body" id="validation-errors" >
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </div>

    <form id="ad-create-form">
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
                                        <input class="form-control" type="text" value="{{old('title')}}" name="title"
                                            placeholder="Advertise Title Here">
                                        
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 form-group">
                                        <label>URL</label>
                                        <input class="form-control" type="text" value="{{old('link')}}" name="link"
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
                                    <select class="form-control custom-select" name="status">
                                        <option value="Publish">
                                            Publish</option>
                                        <option value="Unpublish">
                                            Unpublish</option>
                                    </select>
                                </div>
                                <div
                                    class="form-group">
                                    <input onclick="submitAdNow(event);" type="button" name="Submit" value="Submit"
                                            id="blog_submit" class="btn btn-success">
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
// $(document).ready(function (e) {
    function submitAdNow(event) {
        var api_token = '<?php echo $api_token; ?>';
        event.preventDefault();
        $('#blog_submit').attr('value', 'Submitting...');
        var adCreateForm = document.getElementById("ad-create-form");
            var formData = new FormData(adCreateForm);
  $.ajax({
        type:'POST',
        url: "/api/createadvertisement",
        data: formData,
        enctype: 'multipart/form-data',
        cache:false,
        contentType: false,
        processData: false,
        headers: {
            Authorization: "Bearer " + api_token
        },
        success:function(response){
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
    }
//    });


</script>
@endpush