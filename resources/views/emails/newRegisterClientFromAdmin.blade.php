@component('mail::message')
# Selamat Datang, {{ $user->name }}!

Terima kasih telah mendaftarkan perusahaan Anda pada situs web Kantor Jasa Akuntansi Yasin & Yasin.

Email perusahaan Anda telah didaftarkan langsung oleh Admin Kantor Jasa Akuntansi Yasin & Yasin dengan detail berikut:
- Nama Perusahaan: {{ $user->name }}
- Email: {{ $user->email }}
- Password: {{ $pass }}
- Nomor Telepon: {{ $user->phone }}
- Alamat Perusahaan: {{ $user->address }}

Untuk mengganti password default tersebut, silakan masuk ke situs kami dan buka halaman Profil.

Pemesanan jadwal untuk audit perusahaan dapat dilakukan melalui tombol berikut:

@component('mail::button', ['url' => \URL::to('/kalender')])
Buat Jadwal
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
