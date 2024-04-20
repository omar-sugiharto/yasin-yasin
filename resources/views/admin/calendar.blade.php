@extends('templates.admin')

@section('title')
	Kalender
@endsection

@section('breadcrumb')
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
	<div id="content">
		<button id="b_add" class="btn btn-info mb-4 mr-2"><i class="fa fa-plus mr-2"></i>Tambah Jadwal Manual</button>
		<button id="b_del" class="btn btn-info mb-4 mr-2"><i class="fa fa-trash mr-2"></i>Hapus Banyak Jadwal</button>
		<button id="b_table" class="btn btn-info mb-4"><i class="fa fa-calendar-check mr-2"></i>Tampilkan Jadwal Lampau</button>
		@if (session('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {!! session('message') !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span class="fa fa-times"></span>
                </button>
            </div>
        @endif
		@if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span class="fa fa-times"></span>
                </button>
            </div>
        @endif

        <div class="alert alert-info" role="alert">
			Jadwal yang ditampilkan di kalender hanya untuk jadwal dari bulan <b>{{ Sirius::toIdMonth(date('M', strtotime('-1 month'))).' '.date('Y', strtotime('-1 month')) }}</b>.
        </div>
        @if ($total['booked'])
            <div class="alert alert-warning" role="alert">
                Ada {{ $total['booked'] }} jadwal audit yang menunggu konfirmasi.
            </div>
        @endif
        <div class="card mb-4">
		    <div class="card-header">
		        <i class="fas fa-calendar-alt mr-2"></i>Kalender
		    </div>
		    <div class="card-body">
		    	<div class="mb-3">Keterangan: <span class="badge badge-secondary">KOSONG</span> <span class="badge badge-warning">MENUNGGU KONFORMASI</span> <span class="badge badge-primary">TERKONFIRMASI</span> <span class="badge badge-success">SELESAI</span> <span class="badge badge-danger">DIBATALKAN</span></div>
				<div id="calendar"></div>
		    	<div class="mb-3">Keterangan: <span class="badge badge-secondary">KOSONG</span> <span class="badge badge-warning">MENUNGGU KONFORMASI</span> <span class="badge badge-primary">TERKONFIRMASI</span> <span class="badge badge-success">SELESAI</span> <span class="badge badge-danger">DIBATALKAN</span></div>
		    </div>
		</div>
	</div>

	<div id="table" class="card" style="display: none;">
	    <div class="card-header">
	        <i class="fas fa-calendar-check mr-2"></i>Daftar Jadwal Lampau
	    </div>
	    <div class="card-body">
	        <div class="table-responsive">
				<button type="button" class="btn btn-info mb-3 mr-2 b_cancel"><i class="fa fa-arrow-circle-left mr-2"></i>Kembali</button>
				<button type="button" class="btn btn-danger mb-3" id="b_clean" onclick="event.preventDefault(); document.getElementById('f_cleaner').submit();"><i class="fa fa-trash mr-2"></i>Hapus Jadwal Lampau yang Kosong</button>
	        	<table id="t_events" class="table table-bordered table-striped">
	        		<thead>
	        			<tr>
	        				<th>#</th>
	        				<th width="10%">Tanggal Mulai</th>
	        				<th width="10%">Tanggal Selesai</th>
	        				<th width="25%">Klien</th>
	        				<th width="50%">Catatan Klien</th>
	        				<th width="5%">Status</th>
	        			</tr>
	        		</thead>
	        		<tbody>
	        			@foreach ($pastEvents as $event)
							<tr>
							    <td align="center">{{ $loop->iteration }}</td>
							    <td>{{ Sirius::toIdLongDate($event->start) }}</td>
							    <td>{{ Sirius::toIdLongDate($event->end) }}</td>
							    <td>{{ ($event->user_id != NULL) ? $event->user->name : '-' }}</td>
							    <td>{{ ($event->note != NULL) ? $event->note : '-' }}</td>
							    <td>
								    @if ($event->status == "blank")
								    	<span class="badge badge-secondary">KOSONG</span>
								    @endif
								    @if ($event->status == "booked")
								    	<span class="badge badge-warning">MENUNGGU KONFORMASI</span>
								    @endif
								    @if ($event->status == "confirmed")
								    	<span class="badge badge-primary">TERKONFIRMASI</span>
								    @endif
								    @if ($event->status == "done")
								    	<span class="badge badge-success">SELESAI</span>
								    @endif
								    @if ($event->status == "canceled")
								    	<span class="badge badge-danger">DIBATALKAN</span>
								    @endif
								</td>
							</tr>
	        			@endforeach
					</tbody>
	        	</table>
	        </div>
	    </div>
	</div>

	<div id="add" class="card" style="display: none;">
	    <div class="card-header">
	        <i class="fas fa-plus mr-2"></i>Tambah Jadwal
	    </div>
	    <div class="card-body">
			<form method="post" id="f_add">
				@method('POST')
				@csrf

				<label for="fa_start">Tanggal Mulai</label>
    			<input type="date" class="form-control mb-2" id="fa_start" name="start" required>
				<label for="fa_end">Tanggal Selesai</label>
    			<input type="date" class="form-control mb-2" id="fa_end" name="end" required>

				<button type="button" class="btn btn-danger mt-3 mr-3 b_cancel"><i class="fa fa-times mr-2"></i>Batal</button>
				<button type="submit" class="btn btn-success mt-3 b_save"><i class="fa fa-save mr-2"></i>Simpan</button>
			</form>
		</div>
	</div>

	<div id="show" class="card" style="display: none;">
		<div class="card-header">
	        <i class="fas fa-search mr-2"></i>Lihat Jadwal
	    </div>
	    <div class="card-body">
            <div class="alert alert-info" role="alert">Jadwal ini telah terisi.</div>
			<form method="post" id="f_show">
				@method('PUT')
				@csrf

				<label for="fs_start">Tanggal Mulai</label>
    			<input type="date" class="form-control mb-2" id="fs_start" name="start" disabled>
				<label for="fs_end">Tanggal Selesai</label>
    			<input type="date" class="form-control mb-2" id="fs_end" name="end" disabled>
    			<label for="fs_client">Klien</label>
    			<input type="text" class="form-control mb-2" id="fs_client" name="client" disabled>
    			<label for="fs_note">Catatan Klien</label>
    			<input type="text" class="form-control mb-2" id="fs_note" name="note" disabled>
    			<label for="fs_status">Status</label>
    			<select class="form-control mb-2" id="fs_status" name="status">
    				<option value="blank">Kosongkan</option>
    				<option value="booked">Menuggu Konfirmasi</option>
    				<option value="confirmed">Terkonfirmasi</option>
    				<option value="done">Selesai</option>
    				<option value="canceled">Dibatalkan</option>
                </select>
                <div id="fs_step_container">
                    <label for="fs_step">Tahap</label>
                    <select class="form-control mb-2" id="fs_step" name="step">
                        <option value="document_check">Pengecekan Berkas</option>
                        <option value="audit">Audit</option>
                    </select>
                </div>

				<button type="button" class="btn btn-danger mt-3 mr-3 b_cancel"><i class="fa fa-times mr-2"></i>Kembali</button>
				<button type="button" class="btn btn-primary mt-3" id="b_status"><i class="fa fa-pencil-alt mr-2"></i>Ubah Status</button>
			</form>
		</div>
	</div>

	<div id="edit" class="card" style="display: none;">
	    <div class="card-header">
	        <i class="fas fa-edit mr-2"></i>Ubah Detail Jadwal
	    </div>
	    <div class="card-body">
			<form method="post" id="f_edit">
				<button type="button" id="b_fill" class="btn btn-info mb-4 mr-2"><i class="fa fa-user-plus mr-2"></i>Isi Jadwal Ini dengan Klien</button><br>

				@method('PUT')
				@csrf

				<label for="fe_start">Tanggal Mulai</label>
    			<input type="date" class="form-control mb-2" id="fe_start" name="start" required>
				<label for="fe_end">Tanggal Selesai</label>
    			<input type="date" class="form-control mb-2" id="fe_end" name="end" required>

				<button type="button" class="btn btn-danger mt-3 mr-3 b_cancel"><i class="fa fa-times mr-2"></i>Batal</button>
				<button type="button" class="btn btn-danger mt-3 mr-3" id="b_remove"><i class="fa fa-trash mr-2"></i>Hapus</button>
				<button type="submit" class="btn btn-success mt-3 b_save"><i class="fa fa-save mr-2"></i>Simpan</button>
			</form>
			<form method="post" id="f_fill" style="display: none;">
				<div>
					Jadwal untuk tanggal <b><span id="fill_start"></span></b> hingga <b><span id="fill_end"></span></b>.
				</div>

				@method('PUT')
				@csrf

				<input type="hidden" name="fill" value="1">
				<label for="fe_client">Klien</label>
				<select class="form-control mb-2" id="fe_client" name="client" required>
					@foreach ($clients as $client)
						<option value="{{ $client->id }}">{{ $client->name }}</option>
					@endforeach
				</select>
    			<label for="fe_note">Catatan Klien</label>
    			<input type="text" class="form-control mb-2" id="fe_note" name="note">
    			<label for="fe_status">Status</label>
    			<select class="form-control mb-2" id="fe_status" name="status">
    				<option value="booked">Menuggu Konfirmasi</option>
    				<option value="confirmed" selected>Terkonfirmasi</option>
    				<option value="done">Selesai</option>
    				<option value="canceled">Dibatalkan</option>
    			</select>

				<button type="button" class="btn btn-danger mt-3 mr-3" id="b_back"><i class="fa fa-times mr-2"></i>Batal</button>
				<button type="submit" class="btn btn-success mt-3 b_save"><i class="fa fa-save mr-2"></i>Simpan</button>
			</form>
		</div>
	</div>

	<div id="delete" class="card" style="display: none;">
	    <div class="card-header">
	        <i class="fas fa-trash mr-2"></i>Hapus Banyak Jadwal
	    </div>
	    <div class="card-body">
			<form method="post" id="f_deleter">
				@method('DELETE')
				@csrf

				<label for="fd_start">Tanggal Mulai</label>
    			<input type="date" class="form-control mb-2" id="fd_start" name="start">
				<label for="fd_end">Sampai Tanggal</label>
    			<input type="date" class="form-control mb-2" id="fd_end" name="end">

				<button type="button" class="btn btn-danger mt-3 mr-3 b_cancel"><i class="fa fa-times mr-2"></i>Batal</button>
				<button type="button" class="btn btn-danger mt-3 mr-3" id="b_delete"><i class="fa fa-trash mr-2"></i>Hapus</button>
			</form>
		</div>
	</div>

	<div id="remover" style="display: none;">
		<form method="post" id="f_remover">
			@method('DELETE')
			@csrf
		</form>
	</div>

	<div id="cleaner" style="display: none;">
		<form method="post" id="f_cleaner" action="{{ url('admin/schedules/clean') }}">
			@method('DELETE')
			@csrf
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
							status: "{{ $event->status }}",
							step: "{{ $event->step ?? 'document-check' }}",
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
				selectable: true,
				selectMirror: true,
				dayMaxEvents: true,
				displayEventEnd: true,
                displayEventTime: false,
				locale: 'id',
				select: function(e) {
					$("#fa_start").val(moment(e.start).format("YYYY-MM-DD"));
					$("#fa_end").val(moment(e.end).add(-1, 'day').format("YYYY-MM-DD"));
					$("#fa_end").attr('min', moment(e.start).format("YYYY-MM-DD"));

					$("#content").slideUp();
					$("#add").slideDown();
					calendar.unselect()
				},
				eventClick: function(e) {
					$("#content").slideUp();
					if (e.event.classNames == "event-blank") {
						$("#f_edit").attr('action', '{{ url("admin/schedules") }}/' + e.event.id);
						$("#f_fill").attr('action', '{{ url("admin/schedules") }}/' + e.event.id);
						$("#f_remover").attr('action', '{{ url("admin/schedules") }}/' + e.event.id);
						$("#fe_start").val(moment(e.event.start).format("YYYY-MM-DD"));
						$("#fe_end").val(moment(e.event.end).subtract(1, 'days').format("YYYY-MM-DD"));

						$("#fill_start").html(moment(e.event.start).format("DD/MM/YYYY"));
						$("#fill_end").html(moment(e.event.end).subtract(1, 'days').format("DD/MM/YYYY"));

						$("#edit").slideDown();
					}
					else {
						$("#f_show").attr('action', '{{ url("admin/schedules") }}/' + e.event.id);
						$("#fs_start").val(moment(e.event.start).format("YYYY-MM-DD"));
						$("#fs_end").val(moment(e.event.end).subtract(1, 'days').format("YYYY-MM-DD"));
						$("#fs_client").val(booked[e.event.id].client);
						$("#fs_note").val(booked[e.event.id].note);
						$("#fs_status").val(booked[e.event.id].status);

                        if (booked[e.event.id].status == 'confirmed') {
    						$("#fs_step_container").show();
    						$("#fs_step").val(booked[e.event.id].step);
                        }
                        else {
    						$("#fs_step_container").hide();
                        }

						$("#show").slideDown();
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
								@if ($event->status == "booked")
                                    title: '{{ $event->user->name }}',
									color: '#FF8800',
								@else
									@if ($event->status == "confirmed")
								        @if ($event->step == "document_check")
                                            title: '{{ $event->user->name.' - '."Pengecekan Berkas" }}',
                                        @else
                                            title: '{{ $event->user->name.' - '."Audit" }}',
                                        @endif
									@else
                                        title: '{{ $event->user->name }}',
                                        @if ($event->status == "done")
                                            color: '#00C851',
                                        @else
                                            @if ($event->status == "canceled")
                                                color: '#CC0000',
                                            @endif
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

		    $("#t_events").DataTable({
				"language": {
					"lengthMenu"	: "Menampilkan _MENU_ jadwal per halaman",
					"emptyTable"	: "Masih belum ada jadwal lampau.",
					"zeroRecords"	: "Jadwal yang dicari tidak ditemukan.",
					"info"			: "Halaman _PAGE_ dari _PAGES_",
					"infoEmpty"		: "Tidak ada jadwal yang ditemukan.",
					"infoFiltered"	: "(disaring dari total _MAX_ jadwal)",
				    "loadingRecords": "Sedang memuat ...",
    				"processing"	: "Sedang memproses ...",
    				"search"		: "Cari:",
    				"thousands"		: ".",
				    "paginate": {
				        "first"		: "Pertama",
				        "last"		: "Terakhir",
				        "next"		: "Lanjut",
				        "previous"	: "Kembali"
				    },
				}
			});
		});

		$("#b_del").click(function(){
			$("#content").slideUp();
			$("#delete").slideDown();
		});
		$("#b_add").click(function(){
			$("#fa_date").val("");
			$("#content").slideUp();
			$("#add").slideDown();
		});
		$("#b_table").click(function(){
			$("#content").slideUp();
			$("#table").slideDown();
		});
		$("#b_fill").click(function(){
			$("#f_edit").slideUp();
			$("#f_fill").slideDown();
		});
		$("#b_back").click(function(){
			$("#f_fill").slideUp();
			$("#f_edit").slideDown();
		});
		$(".b_cancel").click(function(){
			$("#content").slideDown();
			$(this).parent().parent().parent().slideUp();
		});

		$("#b_status").click(function(){
			let status = $("#fs_status").val();
			let changed = true;

			if (status == "blank") {
				changed = confirm("Yakin ingin mengosongkan jadwal ini? Data klien pada jadwal ini akan dihapus.");
			}
			else if (status == "canceled") {
				changed = confirm("Yakin ini membatalkan jadwal ini?");
			}

			if (changed) {
				$("#f_show").submit();
			}
		});
		$("#b_remove").click(function(){
			let remove = confirm("Yakin ingin menghapus jadwal ini?");
			if (remove) {
				$("#f_remover").submit();
			}
		});
		$("#b_delete").click(function(){
			let deletes = confirm("Yakin ingin menghapus jadwal di rentang tanggal ini?");
			if (deletes) {
				$("#f_deleter").submit();
			}
		});

		$("#fa_start").change(function(){
			$("#fa_end").attr('min', $("#fa_start").val());
		});
		$("#fe_start").change(function(){
			$("#fe_end").attr('min', $("#fe_start").val());
		});
		$("#fd_start").change(function(){
			$("#fd_end").attr('min', $("#fd_start").val());
		});
		$("#fs_status").change(function(){
            if ($("#fs_status").val() == "confirmed") {
                $("#fs_step_container").slideDown();
            }
            else {
                $("#fs_step_container").slideUp();
            }
		});
	</script>
@endsection
