@component('mail::message')
# Selamat Datang, {{ $name }}!

Terima kasih telah mendaftarkan perusahaan Anda pada situs web Kantor Jasa Akuntansi Yasin & Yasin. Pemesanan jadwal untuk audit perusahaan dapat dilakukan melalui tombol berikut:

@component('mail::button', ['url' => \URL::to('/kalender')])
Buat Jadwal
@endcomponent

Terika kasih dari kami,<br>
{{ config('app.name') }}
@endcomponent
