@component('mail::message')
# Permintaan Jadwal Diterima

Yang terhormat kepada perusahaan {{ $event->user->name }},
kami informasikan bahwa permintaan jadwal audit Anda dengan detail berikut:

- Tanggal: {{ Sirius::toIdLongDate($event->start) }}
- Jam: {{ date('H:i', strtotime($event->start)) }} - {{ date('H:i', strtotime($event->end)) }}
- Catatan: {{ ($event->note != NULL) ? $event->note : "-" }}

Telah kami terima, harap tunggu kehadiran kami di perusahaan Anda.

@component('mail::button', ['url' => \URL::to('https://calendar.google.com/calendar/u/0/r/eventedit?text=Audit+dengan+KJA+Yasin+%26+Yasin&details=' . (($event->note != NULL) ? 'Catatan: ' . $event->note : "") . '&dates=' . date('Ymd', strtotime($event->start)) . 'T' . str_pad((date('His', strtotime($event->start)) - 70000), 6, "0", STR_PAD_LEFT) . 'Z/' . date('Ymd', strtotime($event->end)) . 'T' . str_pad((date('His', strtotime($event->end)) - 70000), 6, "0", STR_PAD_LEFT) . 'Z')])
Pasang Jadwal di Google Calendar
@endcomponent


Jika Anda ingin membatalkan jadwal ini, harap hubungi CS kami melalui:
- Telepon: {{ $contacts['phone'] }}
- Email: {{ $contacts['customer_service_mail'] }}

Kami ucapkan terima kasih,<br>
{{ config('app.name') }}
@endcomponent
