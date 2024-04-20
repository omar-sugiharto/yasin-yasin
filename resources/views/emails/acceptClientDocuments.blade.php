@component('mail::message')
# Berkas yang Anda Kirimkan Telah Disetujui

Berkas yang Anda berikan telah kami setujui.
Sekarang Anda dapat melakukan permohonan audit.

@component('mail::button', ['url' => \URL::to('/kalender')])
Mohon Audit
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
