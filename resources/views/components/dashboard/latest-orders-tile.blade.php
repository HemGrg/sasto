<div class="card">
    <div class="card-header">
        <div class="d-flex">
            <div class="card-title">New Orders</div>
            <div class="ml-auto">
                <a href="{{ route('orders.index') }}">View All</a>
            </div>
        </div>
    </div>

    <table class="custom-table table table-responsive-sm table-hover">
        <thead>
            <tr>
                <td>Order No.</td>
                @if(auth()->user()->hasAnyRole('super_admin|admin'))
                <td>Seller</td>
                @endif
                <td>Customer Name</td>
                <td>Placed On</td>
                <td>Total Amount</td>
                {{-- <th>Track Number</th> --}}
                <td>Payment</td>
                <td class="text-center">Status</td>
                <td class="text-right">Action</td>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr class="category_row{{ $order->id }}">
                <td> #{{ $order->id }}</td>
                @if(auth()->user()->hasAnyRole('super_admin|admin'))
                <td>{{ $order->vendor->shop_name ?? 'N/A' }}</td>
                @endif
                <td>{{ $order->customer->name ?? 'N/A' }}</td>
                <td>
                    <span>{{ $order->created_at->format('d M, Y') }}, {{ date('g:i A', strtotime($order->created_at)) }}</span>
                </td>
                <td>{{ formatted_price($order->total_price) }}</td>
                {{-- <td>{{ $order->track_no ?? 'N/A' }}</td> --}}
                <td>
                    <span class="text-capitalize">{{ $order->payment_type}}</span>
                    <span class="{{ $order->isPaid() ? 'text-success' : 'text-danger' }} text-capitalize">({{ $order->payment_status }})</span>
                </td>
                <td class="text-center"><span class="px-2 py-2 order-status-badge {{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                <td class="text-right">
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-link text-primary"><i class="fa fa-eye mr-1"></i> View</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="42" class="text-center">
                    You do not have any order yet.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
