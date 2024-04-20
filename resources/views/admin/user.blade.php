@extends('templates.admin')

@section('title')
	Pengguna
@endsection

@section('breadcrumb')
	Pengguna
@endsection

@section('content')
	<div id="content">
		<button id="b_create" class="btn btn-info mb-4"><i class="fa fa-user-plus mr-2"></i>Tambah Pengguna</button>
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
		        <i class="fas fa-users mr-2"></i>Daftar Pengguna
		    </div>
		    <div class="card-body">
		        <div class="table-responsive">
		        	<table id="t_users" class="table table-bordered table-striped">
		        		<thead>
		        			<tr>
		        				<th width="5%">#</th>
		        				<th width="30%">Nama</th>
		        				<th width="25%">Email</th>
		        				<th width="5%">Peran</th>
		        				<th width="35%">Tindakan</th>
		        			</tr>
		        		</thead>
		        		<tbody>
		        			@foreach ($users as $user)
								<tr>
								    <td align="center">{{ $loop->iteration }}</td>
								    <td>{{ $user->name }}</td>
								    <td>{{ $user->email }}</td>
								    <td>{{ ($user->role == "admin") ? "Admin" : "Klien" }}</td>
								    <td align="center">
								    	<button type="button" class="btn btn-primary btn-sm m-1 b_edit"><i class="fa fa-eye mr-2"></i>Detail</button>
								    	<a href="{{ url("/admin/user/{$user->id}/contacts") }}" type="button" class="btn btn-success btn-sm m-1"><i class="fa fa-phone mr-2"></i>Kontak</a>
								    	<button type="button" class="btn btn-warning btn-sm m-1 b_reset"><i class="fa fa-key mr-2"></i>Atur Ulang Kata Sandi</button>
								    	<button type="button" class="btn btn-danger btn-sm m-1 b_remove"><i class="fa fa-times mr-2"></i>Hapus</button>

								    	<input type="hidden" class="f_id" value="{{ $user->id }}">
								    	<input type="hidden" class="f_name" value="{{ $user->name }}">
								    	<input type="hidden" class="f_email" value="{{ $user->email }}">
								    	<input type="hidden" class="f_address" value="{{ $user->address }}">
								    	<input type="hidden" class="f_role" value="{{ $user->role }}">
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
	        <i class="fas fa-eye mr-2"></i>Detail Pengguna
	    </div>
	    <div class="card-body">
			<form method="post" action="" id="f_editor">
				@method('PUT')
				@csrf
				<div class="form-group">
					<label for="fe_name">Nama</label>
					<input type="text" class="form-control" id="fe_name" name="name" value="">
				</div>
				<div class="form-group">
					<label for="fe_email">Email</label>
					<input type="email" class="form-control" id="fe_email" name="email" value="">
				</div>
				<div class="form-group">
					<label for="fe_address">Alamat</label>
					<input type="text" class="form-control" id="fe_address" name="address" value="">
				</div>
				<div class="form-group">
					<label for="fe_role">Peran</label>
					<select id="fe_role" name="role" class="form-control">
						<option value="admin">Admin</option>
						<option value="client">Pelanggan</option>
					</select>
				</div>

				<button type="button" class="btn btn-danger mt-3 mr-3 b_cancel"><i class="fa fa-times mr-2"></i>Batal</button>
				<button type="submit" class="btn btn-success mt-3"><i class="fa fa-save mr-2"></i>Simpan Perubahan</button>
			</form>
		</div>
	</div>

	<div id="reseter" class="card" style="display: none;">
		<div class="card-header">
	        <i class="fas fa-key mr-2"></i>Atur Ulang Kata Sandi (<span id="fr_email"></span>)
	    </div>
	    <div class="card-body">
			<form method="post" action="" id="f_reseter">
				@method('PUT')
				@csrf

				<div class="form-group">
					<label for="fr_password">Kata Sandi</label>
					<input type="password" class="form-control" id="fr_password" name="password">
				</div>
				<div class="form-group">
					<label for="fr_password_confirmation">Konfirmasi Kata Sandi</label>
					<input type="password" class="form-control" id="fr_password_confirmation" name="password_confirmation">
				</div>

				<button type="button" class="btn btn-danger mt-3 mr-3 b_cancel"><i class="fa fa-times mr-2"></i>Batal</button>
				<button type="submit" class="btn btn-success mt-3"><i class="fa fa-save mr-2"></i>Simpan</button>
			</form>
		</div>
	</div>

	<div id="creator" class="card" style="display: none;">
	    <div class="card-header">
	        <i class="fas fa-user-plus mr-2"></i>Tambah Pengguna
	    </div>
	    <div class="card-body">
			<form method="post" enctype="multipart/form-data">
				@method('POST')
				@csrf

				<div class="form-group">
					<label for="fc_name">Nama</label>
					<input type="text" class="form-control" id="fc_name" name="name" value="">
				</div>
				<div class="form-group">
					<label for="fc_email">Email</label>
					<input type="email" class="form-control" id="fc_email" name="email" value="">
				</div>
				<div class="form-group">
					<label for="fc_phone">Nomor Telepon</label>
					<input type="text" class="form-control" id="fc_phone" name="phone" value="">
				</div>
				<div class="form-group">
					<label for="fc_address">Alamat</label>
					<input type="text" class="form-control" id="fc_address" name="address" value="">
				</div>
				<div class="form-group">
					<label for="fc_role">Peran</label>
					<select id="fc_role" name="role" class="form-control">
						<option value="admin">Admin</option>
						<option value="client">Pelanggan</option>
					</select>
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
					{ orderable: true },
					{ orderable: false }
				],
				"language": {
					"lengthMenu"	: "Menampilkan _MENU_ pengguna per halaman",
					"emptyTable"	: "Masih belum ada pengguna yang dibuat.",
					"zeroRecords"	: "Pengguna yang dicari tidak ditemukan.",
					"info"			: "Halaman _PAGE_ dari _PAGES_",
					"infoEmpty"		: "Tidak ada pengguna yang ditemukan.",
					"infoFiltered"	: "(disaring dari total _MAX_ pengguna)",
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
			let remove = confirm('Yakin ingin menghapus "' + $(this).parent().children(".f_name").val() + '"?')
			if (remove == true) {
				$("#f_remover").attr('action', '{{ url("admin/users") }}/' + id);
				$("#f_remover").submit();
			}
		});
		$(".b_edit").click(function(){
			let id = $(this).parent().children(".f_id").val();
			let name = $(this).parent().children(".f_name").val();
			let email = $(this).parent().children(".f_email").val();
			let phone = $(this).parent().children(".f_phone").val();
			let address = $(this).parent().children(".f_address").val();
			let role = $(this).parent().children(".f_role").val();
			$("#f_editor").attr('action', '{{ url("admin/users") }}/' + id);
			$("#fe_name").val(name);
			$("#fe_email").val(email);
			$("#fe_phone").val(phone);
			$("#fe_address").val(address);
			$("#fe_role").val(role);
			$("#content").slideUp();
			$("#editor").slideDown();
		});
		$(".b_reset").click(function(){
			let id = $(this).parent().children(".f_id").val();
			let email = $(this).parent().children(".f_email").val();
			$("#f_reseter").attr('action', '{{ url("admin/users") }}/' + id);
			$("#fr_email").html(email);
			$("#content").slideUp();
			$("#reseter").slideDown();
		});
		$(".b_cancel").click(function(){
			$("#content").slideDown();
			$(this).parent().parent().parent().slideUp();
		});
	</script>
@endsection
