@component('mail::message')
## Hi {{ $customerName }},

Your payment for the order #{{ $order->id }} has been refunded.

Keep shopping from Sasto Wholesale.

Thanks,<br>
Support Team<br>
{{ config('app.name') }}<br>
support@sastowholesale.com
@endcomponent
