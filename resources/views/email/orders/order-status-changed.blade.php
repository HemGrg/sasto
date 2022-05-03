@component('mail::message')
## Hi {{ $customerName }},

@switch($order->status)
@case('processing')
We are pleased to share that the item(s) from your order #{{ $order->id }} is been processed.
@break
@case('shipped')
We are pleased to share that the item(s) from your order #{{ $order->id }} have been shipped.
@break
@case('completed')
We are pleased to share that the item(s) from your order #{{ $order->id }} have been delivered.

We hope you are enjoying your recent purchase! Once you have a chance, we would love to hear your shopping experience to keep us constantly improving.
@break
@case('cancelled')
Sorry to be the bearer of bad news, but your order #{{ $order->id }} was cancelled.
@break
@default
@endswitch

@component('mail::button', ['url' => $checkStatusLink])
Order Status
@endcomponent

Thanks,<br>
Support Team<br>
{{ config('app.name') }}<br>
support@sastowholesale.com
@endcomponent
