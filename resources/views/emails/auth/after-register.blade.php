@component('mail::message')
Hi, {{ $user->name }}

Thank you for registering on Laracamp, your account has been activated successfully<br>
Now you can choose your best match camp!

@component('mail::button', ['url' => route('index')])
    Choose camp
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
