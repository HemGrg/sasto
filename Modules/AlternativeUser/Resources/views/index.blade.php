@extends('layouts.admin')

@section('page_title')
Users
@endsection

@section('styles')
<link href="{{ asset('/assets/admin/vendors/DataTables/datatables.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="page-content fade-in-up">
    <x-alerts></x-alerts>
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">Users</div>
            <div>
                <a class="btn btn-info btn-md" href="{{ route('alternative-users.create') }}">Add New</a>
            </div>
        </div>

        <div class="ibox-body">
            <table id="alternative-users-table" class="table table-responsive-sm table-bordered table-hover" cellspacing="0">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Name</th>
                        <th>E-mail</th>
                        <th>Mobile</th>
                        <th>Permissions</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($alternativeUsers as $alternativeUser)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $alternativeUser->name }}</td>
                        <td>{{ $alternativeUser->email }}</td>
                        <td>{{ $alternativeUser->mobile }}</td>
                        <td>
                            @foreach (collect($alternativeUser->permissions) as $permission)
                            <span>{{ Str::replace('_', ' ', ucfirst($permission)) }}</span>
                            @if(!$loop->last)
                            <span>,</span>
                            @endif
                            @endforeach
                        </td>
                        <td>
                            <a title="Edit" class="btn btn-primary border-0" href="{{ route('alternative-users.edit',$alternativeUser->id) }}">
                                <i class="fa fa-edit mr-1"></i> Edit
                            </a>
                            <span class="mx-1"></span>
                            <form action="{{ route('alternative-users.destroy', $alternativeUser->id) }}" method="POST" class="js-delete-alternative-user-form form-inline d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger border-0"><i class="fa fa-trash mr-1"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No Records Found !!</td>
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
            $('#alternative-users-table').DataTable({
                pageLength: 25
                , "aoColumnDefs": [{
                    "bSortable": false
                    , "aTargets": [-1, -2]
                }]
            });
        });


         // Confirm before delete
         $('.js-delete-alternative-user-form').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?'
                    , text: `Are you sure to delete this user? This action is irreversible.`
                    , icon: 'warning'
                    , showCancelButton: true
                    , confirmButtonColor: '#3085d6'
                    , cancelButtonColor: '#d33'
                    , confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.value) {
                        e.target.submit();
                    } else {
                        $(this).find('button[type="submit"]').prop('disabled', false);
                    }
                })
            });

</script>
@endpush
