@component('mail::message')
# change your password

Click in the button below.

@component('mail::button', ['url' => 'http://localhost:4200/response-reset?token='.$token])
Reset  Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent