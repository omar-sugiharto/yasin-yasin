@extends('templates.admin')

@section('title')
	Lampiran
@endsection

@section('breadcrumb')
	Lampiran
@endsection

@section('content')
	<div id="content">
		<button id="b_create" class="btn btn-info mb-4"><i class="fa fa-upload mr-2"></i>Unggah Gambar sebagai Lampiran</button>
		<button id="b_add" class="btn btn-info mb-4"><i class="fa fa-plus mr-2"></i>Tambah Lampiran dari Galeri</button>
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
		        <i class="fas fa-paperclip mr-2"></i>Daftar Lampiran
		    </div>
		    <div class="card-body">
				<form method="post" action="">
					@csrf
		    		@method('DELETE')
		    		<div class="row">
		    			@foreach ($attachment as $attach)
			    			<div class="col-lg-3 col-md-4 col-6">
			    				<input type="checkbox" name="detach[{{ $attach->id }}]" id="attach{{ $loop->iteration }}">
				    			<label for="attach{{ $loop->iteration }}">{{ $attach->name }}</label><br>
								<a href="{{ url('images/user_upload/'.$attach->name.'｜'.$attach->id.$attach->ext) }}" target="_blank"><img src="{{ asset('images/user_upload/'.$attach->name.'｜'.$attach->id.$attach->ext) }}" class="img-thumbnail mb-3" style="cursor: zoom-in;"></a>
						    </div>
				    	@endforeach
		    		</div>

					<button type="submit" class="btn btn-danger mt-3 mb-3 w-100 b_detach"><i class="fa fa-unlink mr-2"></i>Hapus dari Lampiran</button>
		    	</form>
		    </div>
		</div>
	</div>

	<div id="creator" class="card" style="display: none;">
	    <div class="card-header">
	        <i class="fas fa-upload mr-2"></i>Unggah Gambar sebagai Lampiran
	    </div>
	    <div class="card-body" id="image-form">
			<form method="post" enctype="multipart/form-data">
				@method('POST')
				@csrf

				<input type="file" id="fc_choose" name="img" class="file" accept="image/*">
				<label for="fc_choose">Pilih Lampiran</label>
				<div class="input-group">
					<input type="text" class="form-control mb-3" disabled placeholder="Unggah Lampiran ..." id="file">
					<div class="input-group-append">
						<button type="button" class="browse btn btn-primary mb-3">Cari ...</button>
					</div>
				</div>

				<label>Pratinjau</label>
				<div>
					<img src="" id="preview" class="img-thumbnail mb-3">
				</div>

				<label for="fc_name">Nama Lampiran</label>
    			<input class="form-control" id="fc_name" name="name">

				<button type="button" class="btn btn-danger mt-3 mr-3 b_cancel"><i class="fa fa-times mr-2"></i>Batal</button>
				<button type="submit" class="btn btn-success mt-3 b_save"><i class="fa fa-save mr-2"></i>Simpan</button>
			</form>
		</div>
	</div>

	<div id="adder" style="display: none;">
		<div class="card">
			<div class="card-header">
		        <i class="fas fa-plus mr-2"></i>Tambah Lampiran dari Galeri
		    </div>
		    <div class="card-body">
				<button type="button" class="btn btn-danger mt-3 mb-3 w-100 b_cancel"><i class="fa fa-times mr-2"></i>Batal</button>

		        <div class="table-responsive">
		        	<table id="t_images" class="table table-bordered table-striped">
		        		<thead>
		        			<tr>
		        				<th width="3%">#</th>
		        				<th width="15%">Pratinjau</th>
		        				<th width="67%">Nama</th>
		        				<th width="15%">Tindakan</th>
		        			</tr>
		        		</thead>
		        		<tbody>
		        			@foreach ($but as $img)
								<tr>
								    <td align="center">{{ $loop->iteration }}</td>
								    <td align="center"><a href="{{ url('images/user_upload/'.$img->name.'｜'.$img->id.$img->ext) }}" target="_blank"><img src="{{ asset('images/user_upload/'.$img->name.'｜'.$img->id.$img->ext) }}" class="img-thumbnail img_preview mb-3"></a></td>
								    <td>{{ $img->name }}</td>
								    <td align="center">
								    	<button type="button" class="btn btn-primary btn-sm mr-2 b_attach"><i class="fa fa-check mr-2"></i>Pilih</button>

								    	<input type="hidden" class="f_id" value="{{ $img->id }}">
								    </td>
								</tr>
		        			@endforeach
						</tbody>
		        	</table>
		        </div>
		    </div>
		</div>
	</div>

	<div id="attacher" style="display: none;">
		<form method="post" action="" id="f_attacher">
			@method('PUT')
			@csrf
		</form>
	</div>

	<script type="text/javascript">
		$(document).ready(function(){
			$("#t_images").DataTable({
				"columns": [
					{ orderable: true },
					{ orderable: false },
					{ orderable: true },
					{ orderable: false }
				],
				"language": {
					"lengthMenu"	: "Menampilkan _MENU_ gambar per halaman",
					"emptyTable"	: "Masih belum ada gambar yang diunggah.",
					"zeroRecords"	: "Gambar yang dicari tidak ditemukan.",
					"info"			: "Halaman _PAGE_ dari _PAGES_",
					"infoEmpty"		: "Tidak ada gambar yang ditemukan.",
					"infoFiltered"	: "(disaring dari total _MAX_ gambar)",
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

		$(document).on("click", ".browse", function() {
			var file = $(this).parents().find(".file");
			file.trigger("click");
		});
		$('input[type="file"]').change(function(e) {
			var fileName = e.target.files[0].name;
			$("#file").val(fileName);
			$("#fc_name").val(fileName.split(".")[0]);

			var reader = new FileReader();
			reader.onload = function(e) {
			    // get loaded data and render thumbnail.
			    document.getElementById("preview").src = e.target.result;
			};
			// read the image file as a data URL.
			reader.readAsDataURL(this.files[0]);
		});

		$("#b_create").click(function(){
			$("#content").slideUp();
			$("#creator").slideDown();
		});
		$("#b_add").click(function(){
			$("#content").slideUp();
			$("#adder").slideDown();
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
		$(".b_attach").click(function(){
			let id = $(this).parent().children(".f_id").val();
			$("#f_attacher").attr('action', '{{ url("admin/attachments") }}/' + id + '/attach');
			$("#f_attacher").submit();
		});
	</script>
@endsection
