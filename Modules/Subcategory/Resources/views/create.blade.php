@extends('layouts.admin')

@section('content')
<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="{{ route('subcategory.index') }}" class="btn btn-primary ml-md-0 ml-3">Back to listing</a>
            </div>
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Create Sub Category</div>
                    <div class="ibox-tools">
                    </div>
                </div>

                <div class="ibox-body" id="validation-errors">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    </button>
                </div>

                <div class="ibox-body" style="">
                    <form id="subcategory-create-form" class="col-md-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}" placeholder="Enter name">
                        </div>

                        <div class="form-group">
                            <label for="">Category</label>
                            <select class="form-control custom-select" id="category_id" name="category_id">
                            </select>
                        </div>

                        @if(auth()->user()->hasAnyRole(['super_admin', 'admin']))
                        <div class="form-group">
                            <label class="ui-checkbox ui-checkbox-warning">
                                <input type="checkbox" name="is_featured" id="is_featured">
                                <span class="input-span"></span>Shown in Hot Category section of homepage.
                            </label>
                        </div>
                        @endif

                        {{-- <div class="row form-group">
              <label for="" class="col-sm-3">Include In Main Menu:</label>
              <div class="col-sm-1">
                  <label class="ui-checkbox ui-checkbox-warning">
                      <input type="checkbox" name="include_in_main_menu"  id="include_in_main_menu">
                      <span class="input-span"></span>Yes
                  </label>
              </div>
              <label class="col-lg-8"><span class="alert-warning">*Remember:Don't tick on this
                      menu if this is not a Top Menu Category.</span></label>
          </div> --}}


                        <div class="form-group">
                            <label>Image </label>
                            <input class="form-control-file" name="image" type="file" id="fileUpload">
                            <div id="wrapper" class="mt-2">
                                <div id="image-holder">
                                </div>
                            </div>
                        </div>

                        @if( auth()->user()->hasAnyRole('super_admin|admin'))
                        <div class="form-group">
                            <div class="check-list">
                                <label class="ui-checkbox ui-checkbox-primary">
                                    <input name="publish" id="publish" type="checkbox">
                                    <span class="input-span"></span>Publish</label>
                            </div>
                        </div>
                        @endif

                        <div class="form-group">
                            <input onclick="submitSubCategoryNow();" type="button" name="save" value="Save" id="blog_submit" class="btn btn-success px-4 border-0">
                            <!-- <button type="submit" class="btn btn-success">Submit</button> -->
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('push_scripts')
@include('dashboard::admin.layouts._partials.imagepreview')
<script>
    function submitSubCategoryNow() {
        var SubcategoryCreateForm = document.getElementById("subcategory-create-form");
        var formData = new FormData(SubcategoryCreateForm);
        $.ajax({
            type: 'POST',
            url: "/api/createsubcategory",
            data: formData,
            enctype: 'multipart/form-data',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status == 'successful') {
                    window.location.href = "/admin/subcategory";
                    var validation_errors = JSON.stringify(response.message);
                    $('#validation-errors').html('');
                    $('#validation-errors').append('<div class="alert alert-success">' + validation_errors + '</div');
                } else if (response.status == 'unsuccessful') {
                    var validation_errors = JSON.stringify(response.data);
                    var response = JSON.parse(validation_errors);
                    $('#validation-errors').html('');
                    $.each(response, function(key, value) {
                        $('#validation-errors').append('<div class="alert alert-danger">' + value + '</div');
                    });
                }
            }

        });
    }
</script>

<script>
    $(document).ready(function(e) {
        function categories() {

            $.ajax({
                type: 'GET',
                url: '/api/getcategory',
                success: function(response) {
                    console.log(response.data)
                    if (response.data) {
                        var html_options = "<option value=''>select any one</option>";
                        $.each(response.data, function(index, cat_data) {
                            html_options += "<option value='" + cat_data.id + "'>" + cat_data.name + "</option>";
                        });
                        $('#category_id').html(html_options);
                    }
                },
                error: function(error) {
                    $('#notification-bar').text('An error occurred');
                }
            });
        }

        categories()
    });
</script>

@endpush