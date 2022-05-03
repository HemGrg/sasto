@component('mail::message')
# Introduction

Please Click on the button to Reset Password.

@component('mail::button', ['url' => '{{url('password-resetform/'.$token)}}'])
Button Text
@endcomponent

Thanks,<br>
Support Team
{{ config('app.name') }}
vendor@sastowholesale.com
@endcomponent

<a href="{{url('password-resetform/'.$token)}}">Click Here</a> to reset your password!! 

