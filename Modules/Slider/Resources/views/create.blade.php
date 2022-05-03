@extends('layouts.admin')
@section('page_title') {{ ($slider_info) ? "Update" : "Add New"}} slider @endsection

@section('content')

<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">{{ ($slider_info) ? "Update" : "Add New "}} slider</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('slider.index')}}">All slider List</a>
            </div>
        </div>
    </div>

    @if(@$slider_info == null)
    <form class="form form-responsive form-horizontal" action="{{route('slider.store')}}" enctype="multipart/form-data"
        method="post">
        @else
        <form class="form form-responsive form-horizontal" action="{{route('slider.update', $slider_info->id)}}"
            enctype="multipart/form-data" method="post">
            <input type="hidden" name="_method" value="PUT">
            @endif
            {{csrf_field()}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-9 col-md-9 col-12">
                            <div class="ibox">
                                <div class="ibox-head">
                                    <div class="ibox-title">Slider Information</div>
                                </div>
                                <div class="ibox-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 form-group">
                                            <label>Slider Title</label>
                                            <input class="form-control" type="text"
                                                value="{{(@$slider_info->title) ? @$slider_info->title : old('title')}}"
                                                name="title" placeholder="Slider Title Here">
                                            @if($errors->has('title'))
                                            <span class=" alert-danger">{{$errors->first('title')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 form-group">
                                            <label>Slider Description</label>
                                            <input class="form-control" type="text"
                                                value="{{(@$slider_info->description) ? @$slider_info->description : old('description')}}"
                                                name="description" placeholder="Slider Description Here">
                                            @if($errors->has('description'))
                                            <span class=" alert-danger">{{$errors->first('description')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="ibox">
                                <div class="ibox-body">
                                    <div class="form-group">
                                        <label> Upload Banner</label>
                                        <small class="form-text">Recommended image size: 800x650px</small>
                                        <input class="form-control-file" type="file" name="image" id="image" accept="image/*"
                                            onchange="showThumbnail(this);">
                                        @if($errors->has('image'))
                                        <div class="error alert-danger">{{$errors->first('image')}}</div>
                                        @endif
                                    </div>
                                    @php
                                    $thumbnail = asset('assets/admin/images/default.png');
                                    @endphp
                                    @if(isset($slider_info->image) && !empty($slider_info->image) &&
                                    file_exists(public_path().'/images/thumbnail/'.$slider_info->image))
                                    @php
                                    $thumbnail = asset('/images/thumbnail/'.$slider_info->image);
                                    @endphp
                                    @endif
                                    <div class="form-group">
                                        <div class="m-r-10">
                                            <img src="{{$thumbnail}}" alt="No Image"
                                                class=" img img-thumbnail  img-sm rounded" id="thumbnail">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Status:</label>
                                        <select class="form-control" name="status">
                                            <option value="Publish"
                                                {{@($slider_info->status == "publish") ? "selected" :""}}>Publish
                                            </option>
                                            <option value="Unpublish"
                                                {{@($slider_info->status == "unpublish") ? "selected" :""}}>Unpublish
                                            </option>
                                        </select>
                                    </div>
                                    @if($errors->has('status'))
                                    <span class=" alert-danger">{{$errors->first('status')}}</span>
                                    @endif


                                    <div class="form-group">
                                        <button class="btn btn-success" type="submit"> <i class="fa-solid fa-paper-plane mr-2"></i>
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


<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<script type="text/javascript" src="{{asset('/assets/admin/js/laravel-file-manager-ck-editor.js')}}"></script>



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
    function showThumbnailInner(input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();
        }
        reader.onload = function(e){
            $('#inner_image_thumbail').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
</script>

@endsection