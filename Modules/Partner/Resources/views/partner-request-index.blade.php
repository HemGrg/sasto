@extends('layouts.admin')

@section('styles')
<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
@include('admin.section.notifications')
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All Partner Requests</div>
        </div>
        <div class="ibox-body">
            <table id="partners-table" class="table table-striped table-responsive-sm table-bordered table-hover">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Company Name</th>
                        <th>Company Email</th>
                        <th>Partner Type</th>
                        <th>Website</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($partners->count())
                    @foreach($partners as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->company_name }}</td>
                        <td>{{ $data->company_email }}</td>
                        <td>{{ @$data->PartnerType->name }}</td>
                        <td>
                            {{ $data->company_web}}
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <a href="" class="btn btn-success btn-sm view" data-id="{{$data->id}}"><i class="fa fa-eye"> </i> View </a>
                                <div class="mx-2"></div>
                                <form action="{{ route('partner-request.destroy', $data->id) }}" class="js-delete-partner-form form-inline d-inline" method="post" class="d-inline">
                                    @csrf()
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm border-0">
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
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Partner Request Details</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
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
                "bSortable": false,
                "aTargets": [-1, -2, -3]
            }]
        });
        $(document).ready(function() {
            // Confirm before delete
            $('.js-delete-partner-form').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: `You Want to delete this Partner Request??`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Delete it!'
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
    $(document).ready(function() {
        $(".view").click(function(e) {
            e.preventDefault();
            id = $(this).data('id');
            $.ajax({
                method: "post",
                url: "{{route('viewPartnerRequest')}}",
                data: {
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $('#myModal .modal-body').html(data);
                    $('#myModal').modal('show');
                }
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
@endsection