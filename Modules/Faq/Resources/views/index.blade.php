@extends('layouts.admin')

@section('page_title')
Faqs
@endsection

@section('styles')
<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="page-heading">
    <h1 class="page-title">Faqs</h1>
</div>
<div class="ibox-body" id="validation-errors">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">Faqs</div>
            <div>
                <a class="btn btn-info btn-md" href="{{route('faq.create')}}">Add New</a>
            </div>
        </div>

        <div class="ibox-body">
            <table class="table table-striped table-responsive-sm table-bordered table-hover" id="example1" cellspacing="0">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Title</th>
                        <th>Position</th>
                        <th>Status</th>
                        @if( auth()->user()->hasAnyRole('super_admin|admin'))
                        <!-- <th>Change Status</th> -->
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($faqs as $faq)

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $faq->title }}</td>
                        <td>{{ $faq->position }}</td>
                        <td>
                            <div style="display:inline-block; width:100px" class="badge  {{ $faq->is_active==1 ? 'bg-primary' : 'badge-danger' }} text-capitalize">
                                {{ $faq->is_active == 1 ? 'Active' : 'Inactive' }}
                            </div>
                        </td>
                        @if( auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                        <!-- <td>
                            <input type="checkbox" class="js-faq-status btn btn-success btn-sm" rel="{{ $faq->id }}" data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger" data-size="mini" @if($faq->is_active == 1) checked @endif>
                        </td> -->
                        <td>
                            <a title="Edit" class="btn btn-primary btn-sm" href="{{ route('faq.edit',$faq->id) }}">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('faq.destroy', $faq->id) }}" method="POST" class="js-delete-prdoduct-category-form form-inline d-inline">
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
            // Confirm before delete
            $('.js-delete-prdoduct-category-form').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?'
                    , text: `You Want to delete this faq??`
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

@endsection
