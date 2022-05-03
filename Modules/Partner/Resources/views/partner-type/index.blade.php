@extends('layouts.admin')

@section('styles')
<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="page-heading">
    @include('admin.section.notifications')
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All Partner Types</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('partner-type.create')}}">Add New Partner Type</a>
            </div>
        </div>
        <div class="ibox-body">
            <table id="partners-table" class="table table-striped table-responsive-sm table-bordered table-hover">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Published</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($partners->count())
                    @foreach($partners as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->position }}</td>
                        <td>
                            <div class="badge {{ $data->publish ? 'bg-primary' : 'bg-danger'; }}">{{ $data->publish ? 'Published' : 'Not Published' }}</div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <a href="{{ route('partner-type.edit', $data->id) }}" class="btn btn-primary border-0"><i class="fa fa-edit"></i> Edit</a>
                                <div class="mx-2"></div>
                                <form action="{{ route('partner-type.destroy', $data->id) }}" class="js-delete-partner-type-form form-inline d-inline" method="post" class="d-inline">
                                    @csrf()
                                    @method('DELETE')
                                    <button class="btn btn-danger border-0">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="42">
                            You do not have any data yet.
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="{{asset('/assets/admin/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/js/sweetalert.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $('#partners-table').DataTable({
            pageLength: 25,
            "aoColumnDefs": [{
                "bSortable": false
                , "aTargets": [-1, -2]
            }]
        });
        $(document).ready(function() {
            // Confirm before delete
            $('.js-delete-partner-type-form').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?'
                    , text: `You Want to delete this Partner Type??`
                    , icon: 'warning'
                    , showCancelButton: true
                    , confirmButtonColor: '#3085d6'
                    , cancelButtonColor: '#d33'
                    , confirmButtonText: 'Yes, Delete it!'
                }).then((result) => {
                    if (result.value) {
                        e.target.submit();
                    } else {
                        $(this).find('button[type="submit"]').prop('disabled', false);
                    }
                })
            });
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
@endsection
