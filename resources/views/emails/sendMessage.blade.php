@component('mail::message')
# {{ $message['subject'] }}

<i>"{{ $message['message'] }}"</i>
<br>
<br>
Kirim balasan ke email {{ $message['name'] }} di:
{{ $message['email'] }}
@endcomponent
