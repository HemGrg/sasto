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
                    <div class="ibox-title">Create Category</div>
                </div>

                <div class="ibox-body" id="validation-errors">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> </button>
                </div>
                <div class="ibox-body" style="">
                    <form id="category-create-form" class="col-md-6">
                        <div class="form-group ">
                            <label>Category Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}" placeholder="Enter name">
                        </div>

                        <div class="form-group">
                            <label class="ui-checkbox ui-checkbox-warning">
                                <input type="checkbox" name="include_in_main_menu" id="include_in_main_menu">
                                <span class="input-span"></span> Include In Main Menu
                            </label>
                        </div>

                        <div class="form-group ">
                            <label>Upload Category Image </label>
                            <input class="form-control-file" name="image" type="file" id="fileUpload">
                            <div id="wrapper" class="mt-2">
                                <div id="image-holder">
                                </div>
                            </div>
                        </div>
                        @if( auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                        <div class="check-list">
                            <label class="ui-checkbox ui-checkbox-primary">
                                <input name="publish" id="publish" type="checkbox">
                                <span class="input-span"></span>Publish</label>
                        </div>
                        @endif
                        <br>
                        <div class="form-group">
                            <input onclick="submitCategoryNow();" type="button" name="save" value="save" id="blog_submit" class="btn btn-success px-4 border-0">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="popupModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="popup-modal-title" class="modal-title">
                    </h5>
            </div>
            <div class="modal-body">
                <div style="text-align: center;" id="popup-modal-body"></div>
            </div>
            <div class="modal-footer">
                <button id="popup-modal-btn" onclick="closeModal('popupModal');" type="button" class="btn">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('push_scripts')
@include('dashboard::admin.layouts._partials.imagepreview')
<script src="{{ asset('/assets/admin/js/sweetalert.js') }}" type="text/javascript"></script>
<script>
    function FailedResponseFromDatabase(message) {
        html_error = "";
        $.each(message, function(index, message) {
            html_error += '<p class ="error_message text-left"> <span class="fa fa-times"></span> ' + message + '</p>';
        });
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            html: html_error,
            confirmButtonText: 'Close',
            timer: 10000
        });
    }

    function DataSuccessInDatabase(message) {
        Swal.fire({
            position: 'top-end',
            type: 'success',
            title: 'Done',
            html: message,
            confirmButtonText: 'Close',
            timer: 10000,
            toast: true
        });
    }
</script>
<script>
    function submitCategoryNow() {
        var categoryCreateForm = document.getElementById("category-create-form");
        var formData = new FormData(categoryCreateForm);
        $.ajax({
            type: 'POST',
            url: "/api/createcategory",
            data: formData,
            enctype: 'multipart/form-data',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status == 'successful') {
                    DataSuccessInDatabase(JSON.stringify(response.message));
                    window.location.href = "/admin/category";
                } else {
                    var validation_errors = JSON.stringify(response.data);
                    var response = JSON.parse(validation_errors);
                    FailedResponseFromDatabase(response);
                }
            }
        });
    }
</script>

@endpush