@component('mail::message')
## Hi {{ $name }},

Congratulations!!!

Your email address has been verified successfully and you will be able to login once your account is approved by the admin.

Thanks,<br>
Support Team<br>
{{ config('app.name') }}<br>
vendor@sastowholesale.com
@endcomponent
