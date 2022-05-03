@extends('layouts.admin')
@section('content')

<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="{{ route('category.index') }}" class="btn btn-primary ml-md-0 ml-3">Back to listing</a>
            </div>
            <div class="ibox">

                <div class="ibox-head">
                    <div class="ibox-title">Edit Category</div>

                    <div class="ibox-tools">

                    </div>
                </div>
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="ibox-body" id="validation-errors">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                </div>

                <div class="ibox-body" style="">
                    <form id="category-update-form">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <label class="ui-checkbox ui-checkbox-warning">
                                <input type="checkbox" name="include_in_main_menu" id="include_in_main_menu">
                                <span class="input-span"></span> Include In Main Menu
                            </label>
                        </div>

                        <div class="row form-group col-md-6">
                            <label>Image </label>
                            <input class="form-control-file" name="image" type="file" id="fileUpload">
                            <div id="wrapper" class="mt-2">
                                <div id="image-holder">
                                </div>
                            </div>
                        </div>
                        @if (auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                        <div class="check-list">
                            <label class="ui-checkbox ui-checkbox-primary">
                                <input name="publish" id="publish" type="checkbox">
                                <span class="input-span"></span>Publish</label>
                        </div>
                        @endif

                        <br>

                        <div class="form-group">
                            <input onclick="submitCategoryNow();" type="button" name="save" value="save" class="btn btn-success px-4 border-0">
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

@endpush

@push('push_scripts')
<script>
    function submitCategoryNow() {
        var id = "<?php echo $id; ?>";
        var categoryUpdateForm = document.getElementById("category-update-form");
        var formData = new FormData(categoryUpdateForm);
        let url = "/api/updatecategory/" + id;
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            enctype: 'multipart/form-data',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response.data);
                if (response.status == 'successful') {
                    window.location.href = "/admin/category";
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
        var id = <?php echo $id; ?>;

        function editcategory(id) {
            $.ajax({
                type: "get",
                url: "/api/editcategory",
                data: {
                    id: id
                },
                success: function(response) {
                    $('#name').append(response.data.name).val();
                    document.getElementById('name').value = response.data.name;
                    if (response.data.publish == '1') {
                        document.getElementById('publish').checked = true;
                    } else {
                        document.getElementById('publish').checked = false;
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
        editcategory(id);
    });
</script>

@endpush