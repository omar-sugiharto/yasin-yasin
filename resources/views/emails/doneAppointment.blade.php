@component('mail::message')
# Permintaan Jadwal Telah Selesai

Yang terhormat kepada perusahaan {{ $event->user->name }},
kami informasikan bahwa permintaan jadwal audit Anda dengan detail berikut:

- Tanggal: {{ Sirius::toIdLongDate($event->start) }}
- Jam: {{ date('H:i', strtotime($event->start)) }} - {{ date('H:i', strtotime($event->end)) }}
- Catatan: {{ ($event->note != NULL) ? $event->note : "-" }}

Telah selesai dilakukan. Terima kasih telah mempercayakan pengauditan perusahaan Anda dengan perusahaan kami.

Kami ucapkan terima kasih,<br>
{{ config('app.name') }}
@endcomponent
