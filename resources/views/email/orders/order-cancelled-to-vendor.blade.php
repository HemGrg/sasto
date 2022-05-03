@component('mail::message')
The order #{{ $order->id }} was cancelled.

@component('mail::button', ['url' => $checkStatusLink])
Order Status
@endcomponent

Thanks,<br>
Support Team<br>
{{ config('app.name') }}<br>
vendor@sastowholesale.com
@endcomponent
