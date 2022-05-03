@extends('layouts.admin')

@section('page_title') Order @endsection

@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-body">
            <h2 class="page-title"> Order - #{{ $order->id }}</h2>
            @if(auth()->user()->hasAnyRole('super_admin|admin'))
            <p>To be fulfilled by: {{ $order->vendor->shop_name ?? 'N/A' }}</p>
            @endif
            @if ($order->isDealCheckout())
            <span class="badge badge-primary">Deal Checkout</span>
            @endif
        </div>
    </div>

    <div class="mt-2">
        {{-- @include('admin.section.notifications') --}}
        <x-alerts></x-alerts>
    </div>

    <div class="mt-3">
        <div class="row">
            <div class="col-md-8">
                <div class="d-sm-flex justify-content-between font-poppins py-4">
                    <div>
                        <div class="info-box">
                            <span class="info-box-icon bg-primary text-white"><i class="fa fa-suitcase"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text text-sm">Order Status</span>
                                <div class="info-box-number mdb-color-text font-medium">{{ strtoupper($order->status) }}</div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="info-box">
                            <span class="info-box-icon bg-danger text-white"><i class="fa fa-credit-card"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text text-sm">Payment Option</span>
                                <span class="info-box-number mdb-color-text font-medium">{{ strtoupper($order->payment_type) }}</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="info-box">
                            <span class="info-box-icon bg-success text-white"><i class="fa-solid fa-money-bill"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text text-sm">Payment Status</span>
                                <span class="info-box-number mdb-color-text font-medium">{{ strtoupper($order->payment_status) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="get__print" class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="align-self-center">
                                <h5 class="h5-reponsive d-inline-block mdb-color-text">Order ID: #{{ $order->id }}</h5>
                                <div class="text-muted">{{ $order->created_at->isoFormat('lll') }}</div>
                            </div>
                            <div class="align-self-center ml-auto">
                                <button class="print__button btn btn-light my-0 border font-poppins text-capitalize" type="button">Print Invoice</button>
                            </div>
                        </div>
                        <div class="my-3"></div>
                        <table class="table table-responsive-sm border">
                            <thead>
                                <tr>
                                    <th class="text-uppercase">Product Title</th>
                                    <th class="text-uppercase"></th>
                                    <th class="text-uppercase">Shipping</th>
                                    <th class="text-uppercase">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderLists as $orderList)
                                <tr>
                                    <td id="product_title">
                                        <div>{{ $orderList->product_name }}</div>
                                    </td>
                                    <td class="text-nowrap">{{ formatted_price($orderList->unit_price) }} x {{ $orderList->quantity }} = {{ formatted_price($orderList->subtotal_price) }}</td>
                                    <td>{{ formatted_price($orderList->shipping_charge) }}</td>
                                    <td class="text-nowrap">{{ formatted_price($orderList->total_price) }}</td>
                                </tr>
                                @endforeach
                                <tr class="bg-light">
                                    <td></td>
                                    <td>
                                        <div>Subtotal</div>
                                        <div class="font-weight-bold">{{ formatted_price($subTotalPrice) }}</div>
                                    </td>
                                    <td>
                                        <div>Shipping</div>
                                        <div class="font-weight-bold">{{ formatted_price($totalShippingPrice) }}</div>
                                    </td>
                                    <td class="text-nowrap">
                                        <div>Order Total</div>
                                        <div class="font-weight-bold">{{ formatted_price($totalPrice) }}</div>
                                    </td>
                                </tr>
                            <tfoot class="d-none">
                                <tr>
                                    <td colspan="2"></td>
                                    <td class="">Subtotal</td>
                                    <td>{{ formatted_price($subTotalPrice) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td class="">Shipping</td>
                                    <td>{{ formatted_price($totalShippingPrice) }}</td>
                                </tr>
                                <tr class="font-weight-bold">
                                    <td colspan="2"></td>
                                    <td class="text-primary">Order Total</td>
                                    <td class="text-primary text-nowrap">
                                        <div>{{ formatted_price($totalPrice) }}</div>
                                    </td>
                                </tr>
                            </tfoot>

                            </tbody>
                        </table>
                    </div>

                </div>

                {{-- Customer address --}}
                <div class="row mt-3">
                    <div class="col-md-6">
                        @include('order::address-box', ['title' => 'Billing Address', 'address' => $order->billingAddress])
                    </div>
                    <div class="col-md-6">
                        @include('order::address-box', ['title' => 'Shipping Address', 'address' => $order->shippingAddress])
                    </div>
                </div>

            </div>
            <div class="col-md-4">
                @if(in_array($order->status, ['cancelled', 'refunded']))
                <div class="bg-danger text-white p-4 rounded mb-4">
                    <h5 class="text-center">Order <span class="text-capitalize">{{ $order->status }}</span></h5>
                    <p class="text-center">
                        This order has been {{ $order->status }}.
                    </p>
                </div>
                @endif
                @if($order->status == 'completed')
                <div class="bg-success text-white p-4 rounded mb-4">
                    <h5 class="text-center">Order <span class="text-capitalize">{{ $order->status }}</span></h5>
                    <p class="text-center">
                        This order has been Completed.
                    </p>
                </div>
                @endif
                @if(!in_array($order->status, ['cancelled', 'refunded']) || auth()->user()->hasAnyRole('super_admin|admin'))
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('orders.update', $order->id) }}" class="form js-order-status-update-form js-disable-on-submit" method="POST" data-original-status="{{ $order->status }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Order Status</label>
                                <select name="status" class="custom-select form-control @error('status') is-invalid @enderror">
                                    @foreach ($orderStatuses as $status)
                                    <option value="{{ $status }}" @if (old('status', $order->status) == $status) selected @endif>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="update_silently" class="form-check=-input" value="1">
                                    <span>Do not notify customer</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-block">Update Order</button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script src="/assets/admin/js/printThis.js"></script>
<script src="{{asset('/assets/admin/js/sweetalert.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $('.print__button').click(function() {
        $("#get__print").printThis({
            header: null
            , footer: null
        });
    });

</script>
<script>
    $(document).ready(function() {
        // Confirm before changing whole order status
        $('.js-order-status-update-form').on('submit', function(e) {
            e.preventDefault();
            let originalStatus = $(this).data('original-status');
            let newStatus = $(this).find('select[name="status"]').val();
            Swal.fire({
                title: 'Are you sure?'
                , text: `You are changing the order status from  ${originalStatus} to ${newStatus}.`
                , icon: 'warning'
                , showCancelButton: true
                , confirmButtonColor: '#3085d6'
                , cancelButtonColor: '#d33'
                , confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.value) {
                    e.target.submit();
                } else {
                    $(this).find('button[type="submit"]').prop('disabled', false);
                }
            })
        });
    });

</script>
@endsection
