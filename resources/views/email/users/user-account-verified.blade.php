@component('mail::message')
## Hi {{ $name }},

Congratulations!!!

Your Account has been verified. 

@if(!$isVendor)
Enjoy shopping with Sasto Wholesale.
@endif

Thanks,<br>
Support Team<br>
{{ config('app.name') }}<br>
support@sastowholesale.com
@endcomponent
