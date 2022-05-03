@component('mail::message')
## Hi {{ $customerName }},

Thank you for ordering from Sasto Wholesale!

We're excited for you to receive your order #{{ $order->id }} and will notify you once it's on its way. We hope you had a great shopping experience! You can check your order status here.

@component('mail::button', ['url' => $checkStatusLink])
Order Status
@endcomponent

We are unable to change your delivery address once the order is placed. Kindly cancel and reorder using correct shipping address.

Thanks,<br>
Support Team<br>
{{ config('app.name') }}<br>
support@sastowholesale.com
@endcomponent
