@component('mail::message')
# Permintaan Audit

Ada permintaan audit baru!

Berikut detail jadwal yang diminta:
- Perusahaan: {{ $event->user->name }}
- Tanggal: {{ Sirius::toIdLongDate($event->start) }}
- Jam: {{ date('H:i', strtotime($event->start)) }} - {{ date('H:i', strtotime($event->end)) }}
- Catatan: {{ ($event->note != NULL) ? $event->note : "-" }}
- Nomor Telepon: {{ $event->user->phone }}
- Alamat: {{ $event->user->address }}

Jika Anda belum menghubungi perusahaan tersebut untuk mengonfirmasi jadwal,
harap hubungi yang bersangkutan dalam waktu dekat.

@component('mail::button', ['url' => \URL::to('https://calendar.google.com/calendar/u/0/r/eventedit?text=Mengaudit+' . $event->user->name . '&details=' . (($event->note != NULL) ? 'Catatan: ' . $event->note : "") . '&location=' . $event->user->name . '&dates=' . date('Ymd', strtotime($event->start)) . 'T' . str_pad((date('His', strtotime($event->start)) - 70000), 6, "0", STR_PAD_LEFT) . 'Z/' . date('Ymd', strtotime($event->end)) . 'T' . str_pad((date('His', strtotime($event->end)) - 70000), 6, "0", STR_PAD_LEFT) . 'Z')])
Pasang Jadwal di Google Calendar
@endcomponent
@endcomponent
