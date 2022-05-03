@extends('layouts.admin')

@section('page_title') All Orders @endsection

@section('content')
<div class="page-content fade-in-up">
    <div class="card">
        <div class="card-body">
            <div class="mb-4">
                <h4 class="page-title"> Orders</h4>
            </div>

            <x-alerts></x-alerts>

            <div class="mb-4">
                <form action="" class="form-inline">
                    <div class="form-row align-items-center">
                        <div class="col-auto form-group">
                            <input type="text" name="order_id" class="form-control" value="{{ request()->order_id ?? null }}" placeholder="Order Number">
                        </div>
                        <div class="col-auto form-group ">
                            <select name="status" id="" class="custom-select">
                                <option value="">All</option>
                                @foreach (config('constants.order_statuses') as $status)
                                <option value="{{ $status }}" @if(request()->status == $status) selected @endif>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if(auth()->user()->hasAnyRole('admin|super_admin'))
                        <div class="col-auto form-group ">
                            <select name="vendor_id" id="" class="custom-select">
                                <option value="">All</option>
                                @foreach ($vendors as $vendor)
                                <option value="{{ @$vendor->id }}" @if(@request()->vendor->id == @$vendor->id) selected @endif>{{ ucfirst($vendor->shop_name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
            </div>

            <table class="custom-table table table-responsive-sm">
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

            <div class="d-flex justify-content-end">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
