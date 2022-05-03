@extends('layouts.admin')
@section('content')
<div class="page-heading">
    @include('admin.section.notifications')
</div>
<div class="page-content fade-in-up">
    <div class="mb-2">
        <a href="{{ route('deals.index') }}" class="btn btn-primary">Back to listing</a>
    </div>

    <div class="ibox">
        <div class="ibox-body">
            <div>
                <table class="table table-borderless table-sm">
                    <tr>
                        <td class="text-muted">ID</td>
                        <td>{{ $deal->id }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Vendor</td>
                        <td>{{ $deal->vendor->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Customer</td>
                        <td>{{ $deal->user->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Completed</td>
                        <td>{{ $deal->completed_at ? 'Yes' : 'No' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Expires at</td>
                        <td>{{ $deal->expire_at->toDateTimeString() }}</td>
                    </tr>
                </table>
            </div>
            <table class="table table-borderless table-responsive-sm">
                <thead>
                  <tr>
                    <td class="text-muted">#</td>
                    <td class="text-muted">Product</td>
                    <td class="text-muted">Unit Price</td>
                    <td class="text-muted">Quantity</td>
                    <td class="text-muted">Shipping</td>
                    <td class="text-muted text-right">Total</td>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($deal->dealProducts as $dealProduct)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div class="d-flex">
                            <img class="rounded" src="{{ $dealProduct->product->imageUrl() }}" style="width: 3rem;">
                            <div class="ml-3">
                                {{ $dealProduct->product->title }}
                            </div>
                        </div>
                    </td>
                    <td>{{ formatted_price($dealProduct->unit_price) }}</td>
                    <td>{{ $dealProduct->product_qty }}</td>
                    <td>{{ formatted_price($dealProduct->shipping_charge ?? 0) }}</td>
                    <td class="text-right">{{ formatted_price($dealProduct->totalPrice()) }}</td>
                  </tr>
                  @endforeach
                  <tr>
                    <td colspan="4"></td>
                    <td>
                      <div class="text-muted">Subtotal</div>
                      <div class="text-muted">Shipping Charge</div>
                      <hr>
                      <div class="text-muted font-weight-bold">Total</div>
                    </td>
                    <td class="text-right">
                        <div>{{ formatted_price($deal->subTotalPrice()) }}</div>
                        <div>{{ formatted_price($deal->totalShippingCharge()) }}</div>
                        <hr>
                        <div class="font-weight-bold">{{ formatted_price($deal->totalPrice()) }}</div>
                    </td>
                  </tr>
                </tbody>
              </table>
        </div>
    </div>
</div>
@endsection
