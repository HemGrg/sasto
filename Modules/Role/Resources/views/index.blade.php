<?php
$user = Auth::user();
$api_token = $user->api_token;
?>
@extends('layouts.admin')
@section('page_title') All Roles @endsection
@section('styles')

<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
@endsection
@section('content')

<div class="ibox-body" id="validation-errors">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">All Roles</div>
            <!-- <div>
                <a class="btn btn-info btn-md" href="{{route('role.create')}}">New Roles</a>
            </div> -->
        </div>

        <div class="ibox-body" id="validation-errors">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        </div>
        <div class="ibox-body table-responsive-sm" id="appendRole">

        </div>
    </div>

</div>


@endsection
@section('scripts')
<script src="{{asset('/assets/admin/vendors/DataTables/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/js/sweetalert.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $('#example-table').DataTable({
            pageLength: 25,
        });
    })
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        $('.message').fadeOut(3000);
        $('.delete').submit(function(e) {
            e.preventDefault();
            var message = confirm('Are you sure to delete');
            if (message) {
                this.submit();
            }
            return;
        });

    });

    $(function() {
        $("#example1").DataTable();
    });

    function roles() {
        var api_token = '<?php echo $api_token; ?>';
        $.ajax({
            type: 'GET',
            url: '/api/getroles',
            headers: {
                Authorization: "Bearer " + api_token
            },
            success: function(response) {
                console.log(response.message)
                $('#appendRole').html(response.html)
            },
            error: function(error) {
                $('#notification-bar').text('An error occurred');
            }
        });
    }

    roles()
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // function deleteRole(id) {
    //     var api_token = '<?php echo $api_token; ?>';
    //     alert("Are you sure you want to delete??");
    //     // debugger
    //     console.log(id)
    //     $.ajax({
    //         type: "post",
    //         //   url: url,

    //         url: "{{route('api.deleteRole')}}",
    //         data: {
    //             id: id
    //         },
    //         headers: {
    //             Authorization: "Bearer " + api_token
    //         },
    //         success: function(response) {
    //             console.log(response.message)
    //             var validation_errors = JSON.stringify(response.message);
    //             $('#validation-errors').html('');
    //             $('#validation-errors').append('<div class="alert alert-success">' + validation_errors + '</div');
    //         }
    //     });
    // }
</script>
<script>
    $(document).ready(function() {

        $(".view").click(function() {
            debugger
            id = $(this).data('id');
            $.ajax({
                method: "post",
                url: "/api/viewrole",
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
@endsection