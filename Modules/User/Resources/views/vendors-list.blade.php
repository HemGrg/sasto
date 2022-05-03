@extends('layouts.admin')
@section('page_title') All Vendors @endsection
@section('styles')
<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('content')
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All vendors</div>
        </div>
        <div class="ibox-body">
            <table id="example-table" class="table table-striped table-responsive-sm table-bordered table-hover" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>User Name</th>
                        <th>Vendor Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Is Featured</th>
                        <th>Vendor Status</th>
                        <th>Profile</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($vendors as $key=>$data)

                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$data->user->name}}</td>
                        <td>{{@$data->shop_name}}</td>
                        <td>{{$data->user->email}}</td>
                        <td>{{$data->user->phone_num}}</td>
                        @if($data->user->vendor_type == 'approved')
                        <td>
                            <input type="checkbox" id="toggle-event" data-toggle="toggle" class="js-vendor-featured btn btn-success btn-sm" rel="{{$data->id}}" data-on="Featured" data-off="Not Featured" data-onstyle="success" data-offstyle="danger" data-size="mini" @if($data->is_featured == 1) checked @endif>
                        </td>
                        @elseif($data->user->vendor_type == 'new' || $data->user->vendor_type == 'suspended')
                        <td>{{$data->is_approved=='1' ?'Yes':'No' }}</td>
                        @endif
                        <td><span class="btn btn-sm {{vendorStatus($data->user->vendor_type) }} ">{{ ucfirst($data->user->vendor_type) }}</span></td>
                        <td>
                            <a title="View Profile" class="btn btn-info btn-sm" href="{{route('vendor.view',$data->user->id)}}"> <i class="fa fa-eye"></i>
                                View Profile
                            </a>

                        </td>
                    </tr>

                    @endforeach

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
        $('#example-table').DataTable({
            pageLength: 15,
            "aoColumnDefs": [{
                "bSortable": false
                , "aTargets": [-1, -2,-3]
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
    $(function() {
        $('.js-vendor-featured').change(function() {
            var product_id = $(this).attr('rel');
            if ($(this).prop("checked") == true) {
                $.ajax({
                    method: "POST",
                    url: '/api/vendors/' + product_id + '/feature',
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
                    url: '/api/vendors/' + product_id + '/notfeature',
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