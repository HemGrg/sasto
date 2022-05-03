{{-- For vendor --}}
@component('mail::message')
## Hi {{$name}},

You have received a new order #{{ $order->id }}.

Please process the order as soon as possible.

{{-- @component('mail::button', ['url' => $checkStatusLink])
Order Status
@endcomponent --}}

@component('mail::button', ['url' => $viewOrderLink])
Order Status
@endcomponent

Thanks,<br>
Support Team<br>
{{ config('app.name') }}<br>
vendor@sastowholesale.com
@endcomponent
