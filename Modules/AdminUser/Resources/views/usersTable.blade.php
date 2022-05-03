<table class="table table-striped table-responsive-sm table-bordered table-hover" id="appendRole" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>S.N</th>
            <th>Name</th>
            <th>Email</th>
            @if($role=='vendor')
            <th>Vendor Type</th>
            @endif
            <th>Phone</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($details as $key=>$detail)
        <tr>
            <td>{{ $details->firstItem() + $loop->index }}</td>
            <td>{{ucfirst($detail->name)}}</td>
            <td>{{$detail->email}}</td>
            @if($role=='vendor')
            <td>
                <div style="display:inline-block; width:100px" class="badge {{ ($detail->vendor_type == 'new') ? 'bg-primary' : (($detail->vendor_type == 'approved')  ? 'bg-success' : 'badge-danger') }} text-capitalize">
                    {{ ucfirst($detail->vendor_type) }}
                </div>
            </td>
            @endif
            <td>{{$detail->phone_num}}</td>
        </tr>
        @empty
        <tr>
            <td colspan="3">No Records </td>
        </tr>
        @endforelse
    </tbody>
</table>
<div class="d-flex">
    <div>
        Showing {{ $details->firstItem() }} to {{ $details->lastItem() }} of {{ $details->total() }} entries
    </div>
    <div class="ml-auto">
        {{ $details->links() }}
    </div>
</div>