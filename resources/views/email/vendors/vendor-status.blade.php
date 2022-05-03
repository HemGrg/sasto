@component('mail::message')
## Hi {{ $name }},

@switch($status)
@case('approved')
Your request to change vendor status for {{ $shop_name }}  has been {{ $status }}. 

You can login Now!!
@break
@case('new')
Your request to change vendor status for {{ $shop_name }}  has been changed to {{ $status }}.  
@break
@case('suspended')
Your request to change vendor status for {{ $shop_name }}  has been {{ $status }}. 
@component('mail::panel')
Reason:
<br>
{{ $note }}
@endcomponent
@default
@endswitch


Thanks,<br>
Support Team<br>
{{ config('app.name') }}<br>
vendor@sastowholesale.com

@endcomponent
