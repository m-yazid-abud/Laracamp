@component('mail::message')
Hi, {{ $name }}

You are successfully registered on <strong>{{ $campTitle }}</strong> camp.<br>
Check your camp by clicking the button below!

@component('mail::button', ['url' => route('dashboard')])
    My Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
