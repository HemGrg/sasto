{{-- Can be safely deleted --}}
@extends('layouts.admin')
@section('page_title') {{ ($product) ? "Update" : "Add"}} Product @endsection

@section('content')
<div class="page-content fade-in-up">
    <div class="page-heading d-flex mb-3">
        <h1 class="h4-responsive">Product images</h1>
        <div class="ml-auto">
            <a class="btn btn-info btn-md" href="/product/all">All Products</a>
        </div>
    </div>

    @include('product::__partials.product-form-tabs')

    <form class="form form-responsive form-horizontal" action="{{route('product-update', $product->id)}}"
        enctype="multipart/form-data" method="post">
        {{csrf_field()}}
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="ibox">
                            <div class="col-lg-12 col-md-12 col-12">

                                <div class="ibox-body">
                                    <div class="form-group">
                                        <label> Upload product Images</label>
                                        <input class="form-control" type="file" name="image[]" id="image"
                                            accept="image/*" multiple>
                                    </div>
                                    @if(Session::get('image_warning'))
                                    <?php $image_error = Session::get('image_warning'); ?>
                                    @foreach($image_error as $err)
                                    <div class="error alert-danger">{{$err}}</div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @if(isset($product->productimage) && $product->productimage->count())
                            @foreach($product->productimage as $image_key => $image_data)
                            <div class="col-lg-3 col-md-12 col-12  image_id{{$image_data->id}}">
                                <div class="ibox">
                                    @if(isset($image_data->images) && !empty($image_data->images) &&
                                    file_exists(public_path().'/uploads/product/other-image/'.$image_data->images))
                                    <div class="form-group">
                                        <div class="m-r-10 product_images">
                                            <div class="remove_image" data-image_id="{{$image_data->id}}"><i
                                                    class="fa fa-times"></i></div>
                                            <img src="{{asset('/uploads/product/other-image/'.$image_data->images)}}"
                                                alt="No Image" class=" img img-thumbnail  img-sm rounded"
                                                id="thumbnail">
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-body">
                                <div class="form-group">
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
<script src="{{asset('/assets/admin/js/sweetalert.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/js/jquery-ui.js')}}"></script>
<script>
    

    function showThumbnail(input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();
        }
        reader.onload = function(e){
            $('#thumbnail').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }

    $(document).ready(function(){
        $('body').on('click','.remove_image', function(e){
            e.preventDefault();
            var image_id = $(this).data('image_id');
            // alert(image_id);
            $.ajax({
                url: "{{route('deleteImageById')}}",
                method: "POST",
                data:{
                    id: image_id,
                    _token: "{{csrf_token()}}"
                },
                success :function (response){
                    if (response.status == false) {
                        FailedResponseFromDatabase(response.message);
                    }
                    if (response.status == true) {
                        $('.image_id'+image_id).fadeOut(2000);
                        DataSuccessInDatabase(response.message);
                    }
                }
            })
        })
    })
function FailedResponseFromDatabase(message){
    html_error = "";
    $.each(message, function(index, message){
        html_error += '<p class ="error_message text-left"> <span class="fa fa-times"></span> '+message+ '</p>';
    });
    Swal.fire({
        type: 'error',
        title: 'Oops...',
        html:html_error ,
        confirmButtonText: 'Close',
        timer: 10000
    });
}
function DataSuccessInDatabase(message){
    Swal.fire({
        // position: 'top-end',
        type: 'success',
        title: 'Done',
        html: message ,
        confirmButtonText: 'Close',
        timer: 10000
    });
}
</script>

@endsection