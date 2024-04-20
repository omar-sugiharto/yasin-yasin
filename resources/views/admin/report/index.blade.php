@extends('templates.admin')

@section('title')
	Laporan Audit
@endsection

@section('breadcrumb')
	Laporan Audit
@endsection

@section('content')
	<div id="content">
		<button id="b_create" class="btn btn-info mb-4"><i class="fa fa-file-signature mr-2"></i>Tulis Laporan</button>
		@if (session('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span class="fa fa-times"></span>
                </button>
            </div>
        @endif
		<div class="card mb-4">
		    <div class="card-header">
		        <i class="fas fa-copy mr-2"></i>Daftar Laporan
		    </div>
		    <div class="card-body">
		        <div class="table-responsive">
		        	<table id="t_users" class="table table-bordered table-striped">
		        		<thead>
		        			<tr>
		        				<th width="5%">#</th>
		        				<th width="60%">Judul Laporan</th>
		        				<th width="20%">Penulis</th>
		        				<th width="15%">Tindakan</th>
		        			</tr>
		        		</thead>
		        		<tbody>
		        			@foreach ($reports as $report)
								<tr>
								    <td align="center">{{ $loop->iteration }}</td>
								    <td>{{ $report->subject }}</td>
								    <td>{{ $report->user->name }}</td>
								    <td align="center">
								    	<a href="{{ url('/admin/report/'.$report->id) }}"><button type="button" class="btn btn-primary btn-sm m-1 b_edit"><i class="fa fa-eye mr-2"></i>Lihat</button></a>
								    	<button type="button" class="btn btn-danger btn-sm m-1 b_remove"><i class="fa fa-times mr-2"></i>Hapus</button>
								    </td>

								    <input type="hidden" class="f_id" name="id" value="{{ $report->id }}">
								    <input type="hidden" class="f_subject" name="subject" value="{{ $report->subject }}">
								</tr>
		        			@endforeach
						</tbody>
		        	</table>
		        </div>
		    </div>
		</div>
	</div>

	<div id="remover" style="display: none;">
		<form method="post" action="" id="f_remover">
			@method('DELETE')
			@csrf
		</form>
	</div>

	<div id="creator" class="card" style="display: none;">
	    <div class="card-header">
	        <i class="fas fa-file-signature mr-2"></i>Tulis Laporan
	    </div>
	    <div class="card-body">
			<form method="post" enctype="multipart/form-data">
				@method('POST')
				@csrf

				<div class="form-group">
					<label for="fc_subject">Judul Laporan</label>
					<input type="text" class="form-control" id="fc_subject" name="subject" value="">
				</div>
				<div class="form-group">
					<label for="fc_content">Isi Laporan</label>
					<textarea class="form-control" id="fc_content" name="content"></textarea>
				</div>

				<input type="file" id="fc_attachments" name="attachments[]" class="attachments" style="display: none;" multiple>
				<label for="fc_attachments">Lampiran</label>
				<div class="input-group">
					<input type="text" class="form-control mb-3" disabled placeholder="Unggah Lampiran ..." id="attachments">
					<div class="input-group-append">
						<button type="button" class="browse btn btn-primary mb-3">Cari ...</button>
					</div>
				</div>

				<button type="button" class="btn btn-danger mt-3 mr-3 b_cancel"><i class="fa fa-times mr-2"></i>Batal</button>
				<button type="submit" class="btn btn-success mt-3 b_save"><i class="fa fa-save mr-2"></i>Simpan</button>
			</form>
		</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function(){
			$("#t_users").DataTable({
				"columns": [
					{ orderable: true },
					{ orderable: true },
					{ orderable: true },
					{ orderable: false }
				],
				"language": {
					"lengthMenu"	: "Menampilkan _MENU_ laporan per halaman",
					"emptyTable"	: "Masih belum ada laporan yang dibuat.",
					"zeroRecords"	: "Laporan yang dicari tidak ditemukan.",
					"info"			: "Halaman _PAGE_ dari _PAGES_",
					"infoEmpty"		: "Tidak ada laporan yang ditemukan.",
					"infoFiltered"	: "(disaring dari total _MAX_ laporan)",
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

			$(document).on("click", ".browse", function() {
				var file = $(this).parents().find(".file");
				file.trigger("click");
			});
			$('input[type="file"]').change(function(e) {
				let filenames = e.target.files[0].name;
				if (e.target.files.length > 1) {
					for (var i = 1; i < e.target.files.length; i++) {
						filenames += ", " + e.target.files[i].name;
					}
				}
				$("#attachments").val(filenames);
			});
		});

		CKEDITOR.replace('fc_content', {
		    filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
		    filebrowserUploadMethod: 'form'
		});

		$("#b_create").click(function(){
			$("#content").slideUp();
			$("#creator").slideDown();
		});
		$(".b_cancel").click(function(){
			$("#content").slideDown();
			$(this).parent().parent().parent().slideUp();
		});

		$(".b_save").click(function(){
			let dis = $(this);
			setTimeout(function(){
				dis.prop('disabled', true);
			},50);
			dis.html('<i class="spinner-border spinner-border-sm mr-2"></i>Menyimpan ...');
			dis.parent().children(".b_cancel").prop("disabled", true);
		});
		$(".b_remove").click(function(){
			let id = $(this).parent().parent().children(".f_id").val();
			let subject = $(this).parent().parent().children(".f_subject").val();
			let remove = confirm('Yakin ingin menghapus laporan "'+ subject +'"?')
			if (remove == true) {
				$("#f_remover").attr('action', '{{ url("/admin/reports") }}/' + id);
				$("#f_remover").submit();
			}
		});
	</script>
@endsection

@section('addjs')
	<script src="//cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
@endsection
