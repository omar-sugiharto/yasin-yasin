@extends('templates.admin')

@section('title')
	Galeri - Daftar Gambar
@endsection

@section('breadcrumb')
	Galeri / Daftar Gambar
@endsection

@section('content')
	<div id="content">
		<button id="b_create" class="btn btn-info mb-4"><i class="fa fa-upload mr-2"></i>Unggah Gambar</button>
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
		        <i class="fas fa-images mr-2"></i>Daftar Gambar
		    </div>
		    <div class="card-body">
		        <div class="table-responsive">
		        	<table id="t_images" class="table table-bordered table-striped">
		        		<thead>
		        			<tr>
		        				<th>#</th>
		        				<th width="15%">Pratinjau</th>
		        				<th width="42%">Nama</th>
		        				<th width="13%">Pengunggah</th>
		        				<th width="12%">Tanggal Unggah</th>
		        				<th width="15%">Tindakan</th>
		        			</tr>
		        		</thead>
		        		<tbody>
		        			@foreach ($images as $img)
								<tr>
								    <td align="center">{{ $loop->iteration }}</td>
								    <td align="center"><a href="{{ url('images/user_upload/'.$img->name.'｜'.$img->id.$img->ext) }}" target="_blank"><img src="{{ asset('images/user_upload/'.$img->name.'｜'.$img->id.$img->ext) }}" class="img-thumbnail img_preview mb-3"></a></td>
								    <td>{{ $img->name }}</td>
								    <td>{{ $img->user->name }}</td>
								    <td>{{ Sirius::toIdLongDate($img->created_at) }}</td>
								    <td align="center">
								    	<a href="{{ url("/images/user_upload/".$img->name.'｜'.$img->id.$img->ext) }}" target="_blank" type="button" class="btn btn-warning btn-sm m-1 b_show"><i class="fas fa-search-plus mr-2"></i>Perbesar</a><br>
								    	<button type="button" class="btn btn-primary btn-sm m-1 b_edit"><i class="fa fa-edit mr-2"></i>Ubah Nama</button><br>
								    	<button type="button" class="btn btn-danger btn-sm m-1 b_remove"><i class="fa fa-trash mr-2"></i>Buang</button>

								    	<input type="hidden" class="f_id" value="{{ $img->id }}">
								    	<input type="hidden" class="f_name" value="{{ $img->name }}">
								    	<input type="hidden" class="f_ext" value="{{ $img->ext }}">
								    	<input type="hidden" class="f_user_id" value="{{ $img->user_id }}">
								    </td>
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

	<div id="editor" class="card" style="display: none;">
		<div class="card-header">
	        <i class="fas fa-edit mr-2"></i>Ubah Nama Gambar
	    </div>
	    <div class="card-body" id="image-form">
			<form method="post" action="" id="f_editor">
				@method('PUT')
				@csrf
		    	<input class="form-control fe_name" value="" name="name">
				<button type="button" class="btn btn-danger mt-3 mr-3 b_cancel"><i class="fa fa-times mr-2"></i>Batal</button>
				<button type="submit" class="btn btn-success mt-3"><i class="fa fa-save mr-2"></i>Simpan</button>
			</form>
		</div>
	</div>

	<div id="creator" class="card" style="display: none;">
	    <div class="card-header">
	        <i class="fas fa-upload mr-2"></i>Unggah Gambar
	    </div>
	    <div class="card-body" id="image-form">
			<form method="post" enctype="multipart/form-data">
				@method('POST')
				@csrf

				<input type="file" id="fc_choose" name="img" class="file" accept="image/*">
				<label for="fc_choose">Pilih Gambar</label>
				<div class="input-group">
					<input type="text" class="form-control mb-3" disabled placeholder="Unggah Gambar ..." id="file">
					<div class="input-group-append">
						<button type="button" class="browse btn btn-primary mb-3">Cari ...</button>
					</div>
				</div>

				<label>Pratinjau</label>
				<div>
					<img src="" id="preview" class="img-thumbnail mb-3">
				</div>

				<label for="fc_name">Nama Gambar</label>
    			<input class="form-control" id="fc_name" name="name">

				<button type="button" class="btn btn-danger mt-3 mr-3 b_cancel"><i class="fa fa-times mr-2"></i>Batal</button>
				<button type="submit" class="btn btn-success mt-3 b_save"><i class="fa fa-save mr-2"></i>Simpan</button>
			</form>
		</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function(){
			$("#t_images").DataTable({
				"columns": [
					{ orderable: true },
					{ orderable: false },
					{ orderable: true },
					{ orderable: true },
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
		$(".b_remove").click(function(){
			let id = $(this).parent().children(".f_id").val();
			let remove = confirm('Yakin ingin membuang gambar "' + $(this).parent().children(".f_name").val() + $(this).parent().children(".f_ext").val() + '" ke tempat sampah?')
			if (remove == true) {
				$("#f_remover").attr('action', '{{ url("admin/images") }}/' + id);
				$("#f_remover").submit();
			}
		});
		$(".b_edit").click(function(){
			let id = $(this).parent().children(".f_id").val();
			let name = $(this).parent().children(".f_name").val();
			$("#f_editor").attr('action', '{{ url("admin/images") }}/' + id);
			$("#f_editor").children(".fe_name").val(name);
			$("#content").slideUp();
			$("#editor").slideDown();
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
	</script>
@endsection
