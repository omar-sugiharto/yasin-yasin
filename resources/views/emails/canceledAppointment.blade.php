@component('mail::message')
# Permintaan Jadwal Dibatalkan

Yang terhormat kepada perusahaan {{ $event->user->name }},
kami informasikan bahwa permintaan jadwal audit Anda dengan detail berikut:

- Tanggal: {{ Sirius::toIdLongDate($event->start) }}
- Jam: {{ date('H:i', strtotime($event->start)) }} - {{ date('H:i', strtotime($event->end)) }}
- Catatan: {{ ($event->note != NULL) ? $event->note : "-" }}

Telah dibatalkan atas kesepakatan dari kedua belah pihak.

Kami ucapkan terima kasih,<br>
{{ config('app.name') }}
@endcomponent
