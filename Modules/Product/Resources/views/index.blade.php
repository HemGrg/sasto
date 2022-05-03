@extends('layouts.admin')
@section('page_title') All Products @endsection
@section('styles')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('content')
<div class="ibox-body" id="validation-errors">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All Products</div>
            <div>
                @if(auth()->user()->hasRole('vendor'))
                <a class="btn btn-info btn-md" href="{{ route('product.create') }}">New Product</a>
                @endif
            </div>
        </div>
        <div class="ibox-body">
            <div class="mb-4">
                <div class="d-md-flex">
                    <div class="d-flex align-items-md-center">
                        <span class="flex-shrink-0 align-self-center text-nowrap">Showing &nbsp;</span>
                        <button class="form-control form-control-sm custom-select dropdown-toggle d-inline w-auto" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ request('per_page', 15) }}</button>
                        <span class="flex-shrink-0 align-self-center text-nowrap"> &nbsp; Records Per Page</span>
                        <div class="dropdown-menu">
                            <a href="{{ request()->fullUrlWithQuery(['per_page' => 20]) }}" class="dropdown-item" value="true">20</a>
                            <a href="{{ request()->fullUrlWithQuery(['per_page' => 50]) }}" class="dropdown-item" value="true">50</a>
                            <a href="{{ request()->fullUrlWithQuery(['per_page' => 100]) }}" class="dropdown-item" value="true">100</a>
                            <a href="{{ request()->fullUrlWithQuery(['per_page' => 200]) }}" class="dropdown-item" value="true">200</a>
                        </div>
                    </div>
                    <div class="ml-auto mt-3">
                        <form action="" class="form-inline" method="GET">
                            <div class="form-row align-items-center">
                                <div class="col-auto form-group">
                                    <input type="text" name="search" class="form-control" value="{{ request()->get('search') }}" placeholder="Search">
                                </div>
                                <div class="col-auto form-group">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="appendUser">
                @include('product::productsTable')
            </div>
            <div class="d-flex">
                <div>
                    Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} entries
                </div>
                <div class="ml-auto">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{asset('/assets/admin/js/sweetalert.js')}}" type="text/javascript"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="{{asset('/assets/admin/js/jquery-ui.js')}}"></script>
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
            // position: 'top-end',
            type: 'success',
            title: 'Done',
            html: message,
            confirmButtonText: 'Close',
            timer: 10000
        });
    }
</script>
<script>
    // function deleteProduct(el, id) {
    //     var message = confirm('Do You want to delete this product??');
    //     if (message) {
    //         $.ajax({
    //             type: "post",
    //             url: "{{route('api.deleteproduct')}}",
    //             data: {
    //                 id: id
    //             },
    //             success: function(response) {
    //                 var validation_errors = JSON.stringify(response.message);
    //                 $('#validation-errors').html('');
    //                 $('#validation-errors').append('<div class="alert alert-success">' + validation_errors + '</div');
    //                 $(el).closest('tr').remove()
    //             }
    //         });
    //     }
    //     return;
    // }
</script>
<script>
    $(function() {
        $('.ProductStatus').change(function() {
            var product_id = $(this).attr('rel');
            if ($(this).prop("checked") == true) {
                $.ajax({
                    method: "POST",
                    url: '/api/products/' + product_id + '/publish',
                    data: {
                        _method: "put"
                    },
                    success: function(response) {
                        if (response.status == 'false') {
                            FailedResponseFromDatabase(response.message);
                        }
                        if (response.status == 'true') {
                            DataSuccessInDatabase(response.message);
                        }
                    }
                });
            } else {
                $.ajax({
                    method: "POST",
                    url: '/api/products/' + product_id + '/unpublish',
                    data: {
                        _method: "delete"
                    },
                    success: function(response) {
                        if (response.status == 'false') {
                            FailedResponseFromDatabase(response.message);
                        }
                        if (response.status == 'true') {
                            DataSuccessInDatabase(response.message);
                        }
                    }
                });
            }
        })
    })
</script>

@endsection