@extends('layouts.admin')

@section('page_title')Quotations @endsection

@section('styles')
<link href="{{asset('/assets/admin/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="page-content fade-in-up">
    <x-alerts></x-alerts>
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">RFQ</div>
        </div>
        <div class="ibox-body">
            <table class="table table-striped table-responsive-sm table-bordered table-hover" id="quotation-table" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Query By</th>
                        <th>Posted On</th>
                        <th>Replies</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quotations as $quotation)
                    <tr>
                        <td> {{ $loop->iteration }}</td>
                        <td> {{$quotation->purchase}}</td>
                        <td> {{$quotation->quantity}} {{ $quotation->unit }}</td>
                        <td> {{$quotation->user->name ?? null }}</td>
                        <td> {{$quotation->created_at->diffForHumans() }}</td>
                        <td> {{$quotation->replies_count }} suppliers</td>
                        <td class="text-no-wrap d-flex">
                            <a title="view" class="btn btn-success border-0" href="{{ route('quotations.show',$quotation->id) }}">
                                <i class="fa fa-eye"></i> View
                            </a>
                            <div class="mx-2"></div>
                            @if(auth()->user()->hasAnyRole('super_admin|admin'))
                            <form action="{{ route('quotations.destroy', $quotation->id) }}" method="POST" class="js-confirm-delete form-inline d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger border-0"><i class="fa fa-trash"></i> Delete</button>
                            </form>
                            @endif
                            @if(auth()->user()->hasRole('vendor'))
                            <form action="{{ route('quotations.destroy-for-vendor', $quotation->id) }}" method="POST" class="js-confirm-delete form-inline d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger border-0"><i class="fa fa-trash"></i> Delete</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="42" class="text-center">
                            You do not have any Quotations yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('push_scripts')
<script src="{{ asset('/assets/admin/vendors/DataTables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/assets/admin/js/sweetalert.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $('#quotation-table').DataTable({
            pageLength: 25
            , "bSortable": false
            , "aTargets": [-1, -2]
        });

        $('.js-confirm-delete').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?'
                    , text: `This action is irreversible. Are you sure to delete?`
                    , type: 'question'
                    , showCancelButton: true
                    , confirmButtonColor: '#d33'
                    , confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        e.target.submit();
                    } else {
                        $(this).find('button[type="submit"]').prop('disabled', false);
                    }
                })
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
@endpush
