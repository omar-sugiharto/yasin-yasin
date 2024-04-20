@extends('templates.admin')

@section('title')
	Pengguna - Kontak {{ $user->name }}
@endsection

@section('breadcrumb')
    <a href="{{ url('admin/users') }}">&nbsp;Pengguna&nbsp;</a>/&nbsp;Kontak {{ $user->name }}
@endsection

@section('content')
	<div id="content">
		<button id="b_create" class="btn btn-info mb-4"><i class="fa fa-plus mr-2"></i>Tambah Kontak</button>
		@if (session('error'))
            @foreach (session('error') as $err)
            	<div class="alert alert-danger alert-dismissible fade show" role="alert">
	                {{ $err }}
	                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                    <span class="fa fa-times"></span>
	                </button>
	            </div>
            @endforeach
        @endif
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
		        <i class="fas fa-phone mr-2"></i>Daftar Kontak
		    </div>
		    <div class="card-body">
		        <div class="table-responsive">
		        	<table id="t_contacts" class="table table-bordered table-striped">
		        		<thead>
		        			<tr>
		        				<th width="5%">#</th>
		        				<th width="20%">Nama Kontak</th>
		        				<th width="60%">Isi</th>
		        				<th width="15%">Tindakan</th>
		        			</tr>
		        		</thead>
		        		<tbody>
		        			@foreach ($user->contacts as $contact)
								<tr>
								    <td align="center">{{ $loop->iteration }}</td>
								    <td>{{ $contact->name }}</td>
								    <td>{{ $contact->value }}</td>
								    <td align="center">
								    	<button type="button" class="btn btn-primary btn-sm m-1 b_edit"><i class="fa fa-pencil-alt mr-2"></i>Ubah</button>
								    	@if ($contact->name !== "Telepon")
                                            <button type="button" class="btn btn-danger btn-sm m-1 b_remove"><i class="fa fa-times mr-2"></i>Hapus</button>
                                        @endif

								    	<input type="hidden" class="f_id" value="{{ $contact->id }}">
								    	<input type="hidden" class="f_name" value="{{ $contact->name }}">
								    	<input type="hidden" class="f_value" value="{{ $contact->value }}">
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
	        <i class="fas fa-pencil-alt mr-2"></i>Ubah Kontak
	    </div>
	    <div class="card-body">
			<form method="post" action="" id="f_editor">
				@method('PUT')
				@csrf
				<div class="form-group">
					<label for="fe_name">Nama Kontak</label>
					<input type="text" class="form-control" id="fe_name" name="contact_name" value="">
				</div>
				<div class="form-group">
					<label for="fe_email">Isi</label>
					<input type="text" class="form-control" id="fe_value" name="contact_value" value="">
				</div>

				<button type="button" class="btn btn-danger mt-3 mr-3 b_cancel"><i class="fa fa-times mr-2"></i>Batal</button>
				<button type="submit" class="btn btn-success mt-3"><i class="fa fa-save mr-2"></i>Simpan Perubahan</button>
			</form>
		</div>
	</div>

	<div id="creator" class="card" style="display: none;">
	    <div class="card-header">
	        <i class="fas fa-plus mr-2"></i>Tambah Kontak
	    </div>
	    <div class="card-body">
			<form method="post">
				@method('POST')
				@csrf

				<div class="form-group">
					<label for="fc_name">Nama Kontak</label>
					<input type="text" class="form-control" id="fc_name" name="contact_name" value="">
				</div>
				<div class="form-group">
					<label for="fc_value">Isi</label>
					<input type="text" class="form-control" id="fc_value" name="contact_value" value="">
				</div>

				<button type="button" class="btn btn-danger mt-3 mr-3 b_cancel"><i class="fa fa-times mr-2"></i>Batal</button>
				<button type="submit" class="btn btn-success mt-3 b_save"><i class="fa fa-save mr-2"></i>Simpan</button>
			</form>
		</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function(){
			$("#t_contacts").DataTable({
				"columns": [
					{ orderable: true },
					{ orderable: true },
					{ orderable: true },
					{ orderable: false }
				],
				"language": {
					"lengthMenu"	: "Menampilkan _MENU_ kontak per halaman",
					"emptyTable"	: "Masih belum ada kontak yang dibuat.",
					"zeroRecords"	: "Kontak yang dicari tidak ditemukan.",
					"info"			: "Halaman _PAGE_ dari _PAGES_",
					"infoEmpty"		: "Tidak ada kontak yang ditemukan.",
					"infoFiltered"	: "(disaring dari total _MAX_ kontak)",
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

		$("#b_create").click(function(){
			$("#content").slideUp();
			$("#creator").slideDown();
		});
		$(".b_remove").click(function(){
			let id = $(this).parent().children(".f_id").val();
			let remove = confirm('Yakin ingin menghapus kontak "' + $(this).parent().children(".f_name").val() + '"?')
			if (remove == true) {
				$("#f_remover").attr('action', '{{ url("admin/user/{$user->id}/contacts") }}/' + id);
				$("#f_remover").submit();
			}
		});
		$(".b_edit").click(function(){
			let id = $(this).parent().children(".f_id").val();
			let name = $(this).parent().children(".f_name").val();
			let value = $(this).parent().children(".f_value").val();
			$("#f_editor").attr('action', '{{ url("admin/user/{$user->id}/contacts") }}/' + id);
			$("#fe_name").val(name);
			$("#fe_value").val(value);

            if (name == "Telepon") {
    			$("#fe_name").prop('disabled', true);
            }
            else {
    			$("#fe_name").prop('disabled', false);
            }

			$("#content").slideUp();
			$("#editor").slideDown();
		});
		$(".b_cancel").click(function(){
			$("#content").slideDown();
			$(this).parent().parent().parent().slideUp();
		});
	</script>
@endsection
