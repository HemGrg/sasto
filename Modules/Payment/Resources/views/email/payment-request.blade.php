@component('mail::message')

"{{ $vendorName }}" has requested for his remaining payment of {{ price_unit() }} {{ $remainingPayment }}.

@component('mail::button', ['url' => $actionLink])
View Transactions
@endcomponent

From,<br>
{{ config('app.name') }}
@endcomponent
