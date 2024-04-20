@extends('templates.main')

@section('title')
    Kalender
@endsection

@section('addjs')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.0/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.0/locales-all.min.js"></script>
    <script src="https://momentjs.com/downloads/moment.min.js"></script>
@endsection

@section('addcss')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.0/main.min.css">
@endsection

@section('content')
<section class="hero-wrap container">
    <div class="container-fluid px-0">
        <div class="row d-md-flex no-gutters slider-text slider-title align-items-center justify-content-end">
            <div class="one-forth align-items-center ftco-animate">
                <div class="title mt-5">
                    <center><h2>Mohon Audit</h2></center>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container mb-5">
    <div class="container-fluid px-0">
        <div class="no-gutters slider-text slider-title align-items-center">
            <div class="align-items-center ftco-animate">
                <div class="row text-center">
                    @if (session('message'))
                        <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                            {{ session('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span class="fa fa-times"></span>
                            </button>
                        </div>
                    @endif
                    <div class="mb-3">Keterangan: <span class="badge badge-secondary">KOSONG</span> <span class="badge badge-warning">MENUNGGU KONFORMASI</span> <span class="badge badge-primary">TERKONFIRMASI</span> <span class="badge badge-success">SELESAI</span> <span class="badge badge-danger">DIBATALKAN</span></div>
					<div id="calendar" class="w-100"></div>
                    <div class="alert alert-info mt-4 w-100" role="alert">
                        Jika kotak dialog tidak muncul, harap reload browser Anda.
                    </div>
                    <div class="alert alert-danger mt-1 w-100" role="alert">
                        Untuk membatalkan jadwal harap hubungi CS kami melalui telepon ataupun email.
                    </div>
				</div>
            </div>
        </div>
    </div>
</section>

<div style="display: none">
    <form method="post" id="f_fill">
        @method('PUT')
        @csrf

        <input type="hidden" name="fill" value="client">
        <input type="hidden" name="client" value="{{ Auth::user()->id }}">
        <input type="hidden" name="note" id="fe_note">
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        let booked = {
            @foreach ($events as $event)
                @if ($event->user_id != NULL)
                    {{ $event->id }}: {
                        client: "{{ $event->user->name }}",
                        note: "{{ $event->note }}",
                        @if ($event->status == "booked")
                            status: "Menunggu Konfirmasi",
                            step: "-",
                        @endif
                        @if ($event->status == "confirmed")
                            status: "Terkonfirmasi",
                            @if ($event->step == "document_check")
                                step: "Pengecekan Berkas",
                            @else
                                step: "Audit",
                            @endif
                        @endif
                        @if ($event->status == "done")
                            status: "Selesai",
                            step: "-",
                        @endif
                        @if ($event->status == "canceled")
                            status: "Dibatalkan",
                            step: "-",
                        @endif
                    },
                @endif
            @endforeach
        }

        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listMonth'
            },
            dayHeaderFormat: { weekday: 'long' },
            buttonIcons: true,
            dayMaxEvents: true,
            displayEventEnd: true,
            displayEventTime: false,
            locale: 'id',
            eventClick: function(e) {
                if (e.event.classNames == "event-blank") {
                    $("#f_fill").attr('action', '{{ url("admin/schedules") }}/' + e.event.id);

                    let note = prompt("Ingin mengisi jadwal ini?\n\n" +
                          "Tanggal Mulai: " +
                           moment(e.event.start).format("DD-MM-YYYY") + "\n" +
                          "Tanggal Selesai: " +
                           moment(e.event.end).format("DD-MM-YYYY") + "\n" +
                          "Nama Klien: " +
                          "{{ Auth::user()->name }}" + "\n" +
                          "Catatan: "
                    , "-");

                    if (note) {
                        $("#fe_note").val(note);
                        $("#f_fill").submit();
                    }

                }
                else {
                    alert("Jadwal ini telah Anda isi.\n\n" +
                          "Tanggal Mulai: " +
                           moment(e.event.start).format("DD-MM-YYYY") + "\n" +
                          "Tanggal Selesai: " +
                           moment(e.event.end).format("DD-MM-YYYY") + "\n" +
                          "Status: " +
                           booked[e.event.id].status + "\n" +
                          "Tahap: " +
                           booked[e.event.id].step + "\n" +
                          "Catatan: " +
                           booked[e.event.id].note
                    );
                }
            },
            events: [
                @foreach ($events as $event)
                    {
                        id: {{ $event->id }},
                        @if ($event->status == "blank")
                            classNames: 'event-blank',
                            title: '== Kosong ==',
                            color: '#AAAAAA',
                        @else
                            title: '{{ $event->user->name }}',
                            @if ($event->status == "booked")
                                color: '#FF8800',
                            @else
                                @if ($event->status == "done")
                                    color: '#00C851',
                                @else
                                    @if ($event->status == "canceled")
                                        color: '#CC0000',
                                    @endif
                                @endif
                            @endif
                        @endif
                        start: "{{ $event->start }}",
                        end: "{{ date('Y-m-d', strtotime($event->end.' + 1 day')) }}",
                    },
                @endforeach
            ]
        });

        calendar.render();
    });
</script>

@endsection
