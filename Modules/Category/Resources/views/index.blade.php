@extends('layouts.admin')
@section('page_title') All Categories @endsection
@section('styles')

<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('content')
<div class="ibox-body" id="validation-errors">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All Categories</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('category.create')}}">Add Category</a>
            </div>
        </div>

        <div class="ibox-body" id="validation-errors">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        </div>
        {{-- <div class="ibox-body" id="appendCategory"></div> --}}
        <table class="table table-striped table-responsive-sm table-hover dt-responsive display" id="example-table" cellspacing="0" style="width:100%">
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Name</td>
                    <th>Image</td>
                    <th>Include in main menu</td>
                    <th>Total Products</th>
                    <!-- <th>Sub-categories</th> -->
                    @if( auth()->user()->hasRole('vendor'))
                    <th>Publish</th>
                    @endif
                    @if( auth()->user()->hasAnyRole('super_admin|admin'))
                    <th>Publish</th>
                    <th>Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($details as $detail)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $detail->name }}</td>
                    <td>
                        @if($detail->image)
                        <img class="img-fluid rounded" src="{{ $detail->imageUrl('thumbnail') }}" style="width: 3rem;">
                        @else
                        <p>N/A</p>
                        @endif
                    </td>
                    <td>{{ $detail->include_in_main_menu == 1 ? 'Yes' : 'No' }}</td>
                    <td>{{ $detail->products_count }}</td>
                    <!-- <td>{{ $detail->subcategory_count }}</td> -->
                    @if( auth()->user()->hasRole('vendor'))
                    <td>
                        <div style="display:inline-block; width:100px" class="badge {{ $detail->publish==1 ? 'bg-primary' : 'badge-danger' }} text-capitalize">
                            {{ $detail->publish == 1 ? 'Published' : 'Not Published' }}
                        </div>
                    </td>
                    @endif
                    @if( auth()->user()->hasAnyRole('super_admin|admin'))
                    <td>
                        <input type="checkbox" class="CategoryStatus btn btn-success btn-sm" rel="{{$detail->id}}" data-toggle="toggle" data-on="Publish" data-off="Unpublish" data-onstyle="success" data-offstyle="danger" data-size="mini" @if($detail->publish == 1) checked @endif>
                    </td>
                    @endif
                    @if( auth()->user()->hasAnyRole('super_admin|admin'))
                    <td class="text-nowrap">
                        <a title="view" class="btn btn-success btn-sm" href="{{ route('category.view',$detail->id) }}">
                            <i class="fa fa-eye"></i>View
                        </a>
                        <a title="Edit" class="btn btn-primary btn-sm" href="{{ route('category.edit',$detail->id) }}">
                            <i class="fa fa-edit"></i>Edit
                        </a>
                        <button class="btn btn-danger btn-sm" onclick="deleteCategory(this,'{{ $detail->id }}')" style="display:inline"><i class="fa fa-trash"></i>Delete</button>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="42">No Categories found </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{asset('/assets/admin/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="{{asset('/assets/admin/js/sweetalert.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/js/jquery-ui.js')}}"></script>
<script type="text/javascript">
    $(function() {
        $('#example-table').DataTable({
            pageLength: 15,
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [-1, -2],
                "columnDefs": [{
                    "orderable": false,
                    "targets": 0
                }]
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
<script type="text/javascript">
    $(function() {
        $("#sortable").sortable({
            stop: function() {
                $.map($(this).find('tr'), function(el) {
                    var itemID = el.id;
                    var itemIndex = $(el).index();
                    $.ajax({
                        url: "",
                        method: "post",
                        data: {
                            itemID: itemID,
                            itemIndex: itemIndex
                        },
                        success: function(data) {}
                    })
                });
            }
        });


        // Fetch categories
        function categories() {
            $.ajax({
                type: 'GET',
                url: '/api/all-categories',
                success: function(response) {
                    $('#appendCategory').html(response.html)
                    $("#example-table").DataTable();
                },
                error: function(error) {
                    $('#notification-bar').text('An error occurred');
                }
            });
        }

        // load the categories
        // categories();
    });

    function deleteCategory(el, id) {
        let url = "/api/deletecategory/" + id;
        Swal.fire({
            title: 'Are you sure?',
            text: `You Want to delete this Category??`,
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
        // $.ajax({
        //     type: "post",
        //     url: url,
        //     data: {
        //         _method: 'delete'
        //     },
        //     success: function(response) {
        //         var validation_errors = JSON.stringify(response.message);
        //         $('#validation-errors').html('');
        //         $('#validation-errors').append('<div class="alert alert-success">' + validation_errors + '</div');
        //         $(el).closest('tr').remove()
        //     }
        // });
    }

    //category publish/unpublish
    $(".CategoryStatus").change(function() {
        var category_id = $(this).attr('rel');
        if ($(this).prop("checked") == true) {
            $.ajax({
                method: "POST",
                url: '/api/category/' + category_id + '/publish',
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
                url: '/api/category/' + category_id + '/unpublish',
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
    });
</script>
@endsection