@component('mail::message')
## Hi {{$name}},

Please Click on the button to Reset Password.

@component('mail::button', ['url' =>$token])
Reset Password
@endcomponent

Thanks,<br>
Support Team<br>
{{ config('app.name') }}<br>
vendor@sastowholesale.com
@endcomponent