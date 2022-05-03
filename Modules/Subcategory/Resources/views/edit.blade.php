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
                    <div class="ibox-title">Edit Sub Category</div>
                    <div class="ibox-tools">
                    </div>
                </div>
                <div class="ibox-body" id="validation-errors">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                </div>

                <div class="ibox-body" style="">
                    <form id="subcategory-update-form" class="col-md-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" placeholder="Enter name">
                        </div>

                        <div class="form-group">
                            <label for="">Category </label>
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
                                        <input type="checkbox" name="include_in_main_menu" id="include_in_main_menu">
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
                        @if (auth()->user()->hasAnyRole('super_admin|admin'))
                        <div class="form-group">
                            <div class="check-list">
                                <label class="ui-checkbox ui-checkbox-primary">
                                    <input name="publish" id="publish" type="checkbox">
                                    <span class="input-span"></span>Publish</label>
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <input onclick="submitSubCategoryNow();" type="button" name="save" value="save" id="blog_submit" class="btn btn-success">
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
<script>
    function submitSubCategoryNow() {
        var id = "<?php echo $id; ?>";
        var SubcategoryUpdateForm = document.getElementById("subcategory-update-form");
        var formData = new FormData(SubcategoryUpdateForm);
        formData.append('id', id);
        $.ajax({
            type: 'POST',
            url: "/api/updatesubcategory",
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
                    $('#validation-errors').append('<div class="alert alert-success">' + validation_errors +
                        '</div');
                } else if (response.status == 'unsuccessful') {
                    var validation_errors = JSON.stringify(response.data);
                    var response = JSON.parse(validation_errors);
                    $('#validation-errors').html('');
                    $.each(response, function(key, value) {
                        $('#validation-errors').append('<div class="alert alert-danger">' + value +
                            '</div');
                    });
                }
            }

        });
    }
</script>
<script>
    $(document).ready(function() {
        var id = '{{ $id }}';

        function editsubcategory(id) {
            $.ajax({
                type: "get",
                url: "/api/editsubcategory",
                data: {
                    id: id
                },
                success: function(response) {
                    document.getElementById('name').value = response.data.name;
                    if (response.categories) {
                        var html_options = "<option value='" + response.data.category.id + "'>" +
                            response.data.category.name + "</option>";
                        $.each(response.categories, function(index, cat_data) {
                            if (cat_data.id != response.data.category.id) {
                                html_options += "<option value='" + cat_data.id + "'>" +
                                    cat_data.name + "</option>";
                            }
                        });
                        $('#category_id').html(html_options);
                    }
                    if (response.data.publish == '1') {
                        document.getElementById('publish').checked = true;
                    } else {
                        document.getElementById('publish').checked = false;
                    }

                    if (response.data.is_featured == true) {
                        document.getElementById('is_featured').checked = true;
                    } else {
                        document.getElementById('is_featured').checked = false;
                    }

                    if (response.data.include_in_main_menu == '1') {
                        document.getElementById('include_in_main_menu').checked = true;
                    } else if (response.data.include_in_main_menu == '0') {
                        document.getElementById('include_in_main_menu').checked = false;
                    }
                    document.getElementById('image-holder').innerHTML =
                        '<img width="150" height="150" src="<?php echo URL::to('/') . '/images/thumbnail/'; ?>' + response.data
                        .image + '">';

                    //    location.reload();
                }
            });
        }
        editsubcategory(id);
    });
</script>
@endpush