@component('mail::message')
# Hello {{ $user }}

Message: <span style="color:red">{{ $text }} </span>


@component('mail::button', ['url' => url('/')])
View Something
@endcomponent

Thanks,<br>
{{ config('mail.from.name') }}
@endcomponent
