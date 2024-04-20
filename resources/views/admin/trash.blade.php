@extends('templates.admin')

@section('title')
	Galeri - Tempat Sampah
@endsection

@section('breadcrumb')
	Galeri / Tempat Sampah
@endsection

@section('content')
	<div id="content">
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
		        <i class="fas fa-trash mr-2"></i>Isi Tempat Sampah
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
		        				<th width="12%">Tanggal Dibuang</th>
		        				<th width="15%">Tindakan</th>
		        			</tr>
		        		</thead>
		        		<tbody>
		        			@foreach ($trash as $img)
								<tr>
								    <td align="center">{{ $loop->iteration }}</td>
								    <td align="center"><a href="{{ url('images/user_upload/'.$img->name.'｜'.$img->id.$img->ext) }}" target="_blank"><img src="{{ asset('images/user_upload/'.$img->name.'｜'.$img->id.$img->ext) }}" class="img-thumbnail img_preview mb-3"></a></td>
								    <td>{{ $img->name }}</td>
								    <td>{{ $img->user->name }}</td>
								    <td>{{ Sirius::toIdLongDate($img->deleted_at) }}</td>
								    <td align="center">
								    	<button type="button" class="btn btn-primary btn-sm m-1 b_restore"><i class="fa fa-trash-restore mr-2"></i>Kembalikan</button>
								    	<button type="button" class="btn btn-danger btn-sm m-1 b_remove"><i class="fa fa-times-circle mr-2"></i>Hapus Permanen</button>

								    	<input type="hidden" class="f_id" value="{{ $img->id }}">
								    	<input type="hidden" class="f_name" value="{{ $img->name }}">
								    	<input type="hidden" class="f_ext" value="{{ $img->ext }}">
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

	<div id="restorer" style="display: none;">
		<form method="post" action="" id="f_restorer">
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
					{ orderable: true },
					{ orderable: true },
					{ orderable: false }
				],
				"language": {
					"lengthMenu"	: "Menampilkan _MENU_ gambar per halaman",
					"emptyTable"	: "Masih belum ada gambar yang dihapus.",
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

		$(".b_remove").click(function(){
			let id = $(this).parent().children(".f_id").val();
			let remove = confirm('Yakin ingin menghapus gambar "' + $(this).parent().children(".f_name").val() + $(this).parent().children(".f_ext").val() + '" secara permanen?')
			if (remove == true) {
				$("#f_remover").attr('action', '{{ url("admin/images/trash") }}/' + id + '/vanish');
				$("#f_remover").submit();
			}
		});

		$(".b_restore").click(function(){
			let id = $(this).parent().children(".f_id").val();
			let restore = confirm('Yakin ingin mengembalikan gambar "' + $(this).parent().children(".f_name").val() + $(this).parent().children(".f_ext").val() + '" ke galeri?')
			if (restore == true) {
				$("#f_restorer").attr('action', '{{ url("admin/images/trash") }}/' + id + '/restore');
				$("#f_restorer").submit();
			}
		});
	</script>
@endsection
