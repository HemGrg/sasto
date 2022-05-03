@extends('layouts.admin')

@section('page_title')
Product Categories
@endsection

@section('styles')
<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="page-heading">
    <h1 class="page-title">Product Categories</h1>
</div>
<div class="ibox-body" id="validation-errors">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">Product Categories</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('product-category.create')}}">Add New</a>
            </div>
        </div>

        <div class="ibox-body">
            <table class="table table-striped table-responsive-sm table-bordered table-hover" id="example1" cellspacing="0">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Image</th>
                        <th>Falls Under</th>
                        <th>Products</th>
                        {{-- <th>In Homepage</th> --}}
                        @if( auth()->user()->hasRole('vendor'))
                        <th>Publish</th>
                        @endif
                        @if( auth()->user()->hasAnyRole('super_admin|admin'))
                        <th>Change Status</th>
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($productCategories as $productCategory)

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $productCategory->name }}</td>
                        <td>{{ $productCategory->slug }}</td>
                        <td>
                            @if($productCategory->image)
                            <img class="img-fluid rounded" src="{{ $productCategory->imageUrl() }}" style="width: 3rem;">
                            @else
                            <p>N/A</p>
                            @endif
                        </td>
                        <td>{{ $productCategory->subcategory->name }}</td>
                        <td>{{ $productCategory->products_count }}</td>
                        {{-- <td>{{ $productCategory->is_featured==1 ? 'Yes' : 'No' }}</td> --}}
                        @if( auth()->user()->hasRole('vendor'))
                        <td>
                            <div style="display:inline-block; width:100px" class="badge  {{ $productCategory->publish==1 ? 'bg-primary' : 'badge-danger' }} text-capitalize">
                                {{ $productCategory->publish == 1 ? 'Published' : 'Not Published' }}
                            </div>
                        </td>
                        @endif
                        @if( auth()->user()->hasAnyRole('super_admin|admin'))
                        <td>
                            <input type="checkbox" class="js-product-category-status btn btn-success btn-sm" rel="{{ $productCategory->id }}" data-toggle="toggle" data-on="Publish" data-off="Unpublish" data-onstyle="success" data-offstyle="danger" data-size="mini" @if($productCategory->publish == 1) checked @endif>
                        </td>
                        <td class="text-no-wrap">
                            {{-- <a title="view" class="btn btn-success btn-sm" href="{{ route('subcategory.view',$productCategory->id) }}">
                            <i class="fa fa-eye"></i>
                            </a> --}}
                            <a title="Edit" class="btn btn-primary btn-sm" href="{{ route('product-category.edit',$productCategory->id) }}">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('product-category.destroy', $productCategory->id) }}" method="POST" class="js-delete-prdoduct-category-form form-inline d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">No Records Found !!</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="{{asset('/assets/admin/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="{{asset('/assets/admin/js/sweetalert.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $('#example1').DataTable({
            pageLength: 25
            , "aoColumnDefs": [{
                "bSortable": false
                , "aTargets": [-1, -2]
            }]
        });

        $(document).ready(function() {
            // Confirm before changing package status
            $('.js-package-status-update-form').on('submit', function(e) {
                e.preventDefault();
                let originalStatus = $(this).data('original-status');
                let newStatus = $(this).find('select[name="status"]').val();
                Swal.fire({
                    title: 'Are you sure?'
                    , text: `You are changing the package status from  ${originalStatus} to ${newStatus}.`
                    , icon: 'warning'
                    , showCancelButton: true
                    , confirmButtonColor: '#3085d6'
                    , cancelButtonColor: '#d33'
                    , confirmButtonText: 'Yes, change it!'
                }).then((result) => {
                    if (result.value) {
                        e.target.submit();
                    } else {
                        $(this).find('button[type="submit"]').prop('disabled', false);
                    }
                })
            });

            // Confirm before delete
            $('.js-delete-prdoduct-category-form').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?'
                    , text: `You are deleting a product category. It will also delete products under this category. Try unpublishing or renaming, if it works for you.`
                    , icon: 'warning'
                    , showCancelButton: true
                    , confirmButtonColor: '#3085d6'
                    , cancelButtonColor: '#d33'
                    , confirmButtonText: 'Yes, change it!'
                }).then((result) => {
                    if (result.value) {
                        e.target.submit();
                    } else {
                        $(this).find('button[type="submit"]').prop('disabled', false);
                    }
                })
            });
        });
    });

</script>

<script>
    function FailedResponseFromDatabase(message) {
        html_error = "";
        $.each(message, function(index, message) {
            html_error += '<p class ="error_message text-left"> <span class="fa fa-times"></span> ' + message + '</p>';
        });
        Swal.fire({
            type: 'error'
            , title: 'Oops...'
            , html: html_error
            , confirmButtonText: 'Close'
            , timer: 10000
        });
    }

    function DataSuccessInDatabase(message) {
        Swal.fire({
            position: 'top-end'
            , type: 'success'
            , title: 'Done'
            , html: message
            , confirmButtonText: 'Close'
            , timer: 10000
            , toast: true
        });
    }

</script>

<script>
    $(function() {
        $('.js-product-category-status').change(function() {
            let id = $(this).attr('rel');
            let status = $(this).prop('checked') == true ? 1 : 0;
            let url = "/api/product-category/" + id;
            if (status == 1) {
                url = url + '/publish';
            } else {
                url = url + '/unpublish';
            }
            $.ajax({
                method: "POST"
                , url: url
                , data: {
                    _method: "patch"
                }
                , success: function(response) {
                    if (response.status == 'success') {
                        DataSuccessInDatabase(response.message);
                    } else {
                        FailedResponseFromDatabase(response.message);
                    }
                }
                , error: function(error) {
                    FailedResponseFromDatabase('Something went wrong.');
                }
            });
        })
    })

</script>

@endsection
