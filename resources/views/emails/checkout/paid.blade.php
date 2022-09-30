@component('mail::message')
# Hi, {{ $checkout->user->name }}

<br>
Your payment has been confirmed succesfully, now you can enjoy the benefits of {{ $checkout->camp->title }} camp !

@component('mail::button', ['url' => route('dashboard')])
    My Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
