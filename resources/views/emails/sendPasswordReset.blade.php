@component('mail::message')
# Atur Ulang Kata Sandi

Seseorang telah meminta untuk mengur ulang kata sandi akun Anda di situs Kantor Jasa Akuntansi Yasin & Yasin.
Apabila ini Anda, silakan klik tombol berikut untuk mengatur ulang kata sandi akun Anda:

@component('mail::button', ['url' => \URL::to('/forgot?token=' . $token)])
Atur Ulang Kata Sandi
@endcomponent

Jika tombol tersebut tidak bekerja, harap lakukan copy-paste link di bawah ini ke address bar browser Anda:

{{ \URL::to('/forgot?token=' . $token) }}

Token ini hanya berlaku selama 1 jam setelah Anda melakukan permintaan pengaturan ulang kata sandi Anda.

Kami ucapkan terima kasih,<br>
{{ config('app.name') }}
@endcomponent
