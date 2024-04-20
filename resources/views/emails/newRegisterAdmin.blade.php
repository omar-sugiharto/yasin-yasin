@component('mail::message')
# Selamat Datang, {{ $user->name }}!

Email Anda telah didaftarkan sebagai Admin pada situs web Kantor Jasa Akuntansi Yasin & Yasin dengan detail berikut:
- Nama: {{ $user->name }}
- Email: {{ $user->email }}
- Password: {{ $pass }}
- Nomor Telepon: {{ $user->phone }}
- Alamat: {{ $user->address }}

Untuk mengganti password default tersebut, silakan masuk ke situs kami dan buka halaman Profil, atau Anda juga dapat melakukannya melalui halaman Admin.

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
