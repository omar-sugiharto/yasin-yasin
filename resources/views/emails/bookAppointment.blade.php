@component('mail::message')
# Permintaan Jadwal Terkirim

Terima kasih telah memesan jadwal audit dengan Kantor Jasa Akuntansi Yasin & Yasin. Permintaan Anda telah diteruskan ke yang bersangkutan.

Berikut detail jadwal yang Anda minta:
- Perusahaan: {{ $event->user->name }}
- Tanggal: {{ Sirius::toIdLongDate($event->start) }}
- Jam: {{ date('H:i', strtotime($event->start)) }} - {{ date('H:i', strtotime($event->end)) }}
- Catatan: {{ ($event->note != NULL) ? $event->note : "-" }}

Dalam waktu dekat Anda akan mendapat telepon dari kami untuk konfirmasi.

Jika Anda ingin membatalkan jadwal ini, harap hubungi CS kami melalui:
- Telepon: {{ $contacts['phone'] }}
- Email: {{ $contacts['customer_service_mail'] }}

Kami ucapkan terima kasih,<br>
{{ config('app.name') }}
@endcomponent
