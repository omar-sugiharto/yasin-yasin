@component('mail::message')
# Klien {{ $name }} Memperbarui Dokumennya

{{ $name }} telah memperbarui dokumennya, harap periksa dokumennya secepatnya.

Periksa dokumennya melalui Ruang Admin;

@component('mail::button', ['url' => \URL::to('/admin/documents')])
Menuju Ruang Admin
@endcomponent
@endcomponent
