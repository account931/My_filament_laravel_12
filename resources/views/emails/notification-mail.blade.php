@component('mail::message')
# Hello {{ $user->name }}

Message: <span style="color:red">{{ $text }} </span>

NB: Sent via notification!!!

Your invoice **{{ $invoice }}** has been paid successfully.

@component('mail::button', ['url' => url('/invoices/'.$invoice)])
View Invoice
@endcomponent

Thanks,<br>
{{ config('mail.from.name') }}
@endcomponent
