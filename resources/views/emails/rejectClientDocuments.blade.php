@component('mail::message')
# Berkas yang Anda Kirimkan Ditolak

Berkas yang Anda berikan tidak dapat kami setujui.
Harap perhatikan kembali berkas-berkas yang Anda kirimkan,
pastikan semua berkas yang dikirim sesuai dengan apa yang kami minta.

@component('mail::button', ['url' => \URL::to('/profil#pemberkasan')])
Perbarui Berkas
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
