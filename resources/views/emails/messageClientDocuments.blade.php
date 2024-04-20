@component('mail::message')
# Pesan Dari KJA Yasin & Yasin Soal Berkas Anda

Berikut pesan yang dikirim:
"{{ $message }}"

@component('mail::button', ['url' => \URL::to('/kalender')])
Mohon Audit
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
