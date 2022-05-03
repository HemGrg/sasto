@extends('layouts.admin')
@section('page_title') All Sub Categories @endsection
@section('styles')
<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('content')
<div class="ibox-body" id="validation-errors">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All Sub Categories</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('subcategory.create')}}">New Sub Category</a>
            </div>
        </div>

        <div class="ibox-body">
            <table class="table table-striped table-responsive-sm table-bordered table-hover" style="width:100%" id="example1" cellspacing="0">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th>In Homepage</th>
                        <th>Products</th>
                        @if( auth()->user()->hasRole('vendor'))
                        <th>Publish</th>
                        @endif
                        @if( auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                        <th>Change Status</th>
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($details as $key=>$detail)

                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$detail->name}}</td>
                        <td>
                            @if($detail->image)
                            <img class="img-fluid rounded" src="{{ $detail->imageUrl('thumbnail') }}" style="width: 3rem;">
                            @else
                            <p>N/A</p>
                            @endif
                        </td>
                        <td>{{$detail->category->name}}</td>
                        <td>{{$detail->is_featured==1? 'Yes':'No'}}</td>
                        <td>{{ $detail->products_count }}</td>
                        @if( auth()->user()->hasRole('vendor'))
                        <td>
                            <div style="display:inline-block; width:100px" class="badge  {{ $detail->publish==1 ? 'bg-primary' : 'badge-danger' }} text-capitalize">
                                {{ $detail->publish == 1 ? 'Published' : 'Not Published' }}
                            </div>
                        </td>
                        @endif
                        @if( auth()->user()->hasAnyRole('super_admin|admin'))
                        <td>
                            <input type="checkbox" class="SubcategoryStatus btn btn-success btn-sm" rel="{{$detail->id}}" data-toggle="toggle" data-on="Publish" data-off="Unpublish" data-onstyle="success" data-offstyle="danger" data-size="mini" @if($detail->publish == 1) checked @endif>
                        </td>
                        <td class="text-nowrap">
                            <a title="view" class="btn btn-success btn-sm" href="{{route('subcategory.view',$detail->id)}}">
                                <i class="fa fa-eye"></i>View
                            </a>
                            <a title="Edit" class="btn btn-primary btn-sm" href="{{route('subcategory.edit',$detail->id)}}">
                                <i class="fa fa-edit"></i>Edit
                            </a>
                            <button class="btn btn-danger btn-sm delete" onclick="deleteSubcategory(this,'{{ $detail->id }}')" class="btn btn-danger" style="display:inline"><i class="fa fa-trash"></i>Delete</button>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">No Records </td>
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
            pageLength: 25,
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [-1, -2]
            }]
        });
    })
</script>

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
    function subcategories() {
        $.ajax({
            type: 'GET',
            url: '/api/getsubcategories',
            success: function(response) {
                $('#appendCategory').html(response.html)
                $("#example1").DataTable();
            },
            error: function(error) {
                $('#notification-bar').text('An error occurred');
            }
        });
    }

    // subcategories()

    function deleteSubcategory(el, id) {
        let url = "/api/deletesubcategory/" + id;
        Swal.fire({
            title: 'Are you sure?',
            text: `You Want to delete this Sub Category??`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "post",
                    url: url,
                    data: {
                        _method: 'delete'
                    },
                    success: function(response) {
                        var validation_errors = JSON.stringify(response.message);
                        $('#validation-errors').html('');
                        $('#validation-errors').append('<div class="alert alert-success">' + validation_errors + '</div');
                        $(el).closest('tr').remove()
                    }
                });
            } else {
                $(this).find('button[type="submit"]').prop('disabled', false);
            }
        })


    }
</script>

<script>
    $(function() {
        $('.SubcategoryStatus').change(function() {
            var subcat_id = $(this).attr('rel');
            if ($(this).prop("checked") == true) {
                $.ajax({
                    method: "POST",
                    url: '/api/subcategory/' + subcat_id + '/publish',
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
                    url: '/api/subcategory/' + subcat_id + '/unpublish',
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