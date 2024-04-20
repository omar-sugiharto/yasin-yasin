@extends('templates.admin')

@section('title')
	Berkas Klien - {{ $user->name }}
@endsection

@section('breadcrumb')
	<a href="{{ url('/admin/documents/') }}">&nbsp;Berkas Klien</a>&nbsp;/ {{ $user->name }}
@endsection

@section('content')
    <div id="content">
		<button id="b_create" class="btn btn-info mb-4 mr-2"><i class="fas fa-plus mr-2"></i>Tambah Berkas</button>
		@if ($user->document_status == "waiting" || $user->document_status == "rejected")
            <button id="b_accept" class="btn btn-success mb-4 mr-2"><i class="fas fa-check-circle mr-2"></i>Terima Berkas</button>
        @endif
		@if ($user->document_status == "waiting" || $user->document_status == "accepted")
            <button id="b_reject" class="btn btn-danger mb-4 mr-2"><i class="fas fa-times-circle mr-2"></i>Tolak Berkas</button>
        @endif
        <button id="b_message" class="btn btn-warning mb-4 mr-2"><i class="fas fa-envelope mr-2"></i>Kirim Pesan Perihal Berkas</button>

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
		@if (session('documentsMessage'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('documentsMessage') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span class="fa fa-times"></span>
                </button>
            </div>
        @endif
        <div class="card mb-4">
		    <div class="card-header">
		        <i class="fas fa-copy mr-2"></i>Daftar Berkas
                @if ($user->document_status == "rejected")
                    <span class="ml-1 badge badge-danger">DITOLAK</span>
                @else
                    @if ($user->document_status == "waiting")
                        <span class="ml-1 badge badge-warning">MENUNGGU PERSETUJUAN</span>
                    @else
                        @if ($user->document_status == "accepted")
                            <span class="ml-1 badge badge-success">DISETUJUI</span>
                        @else
                            @if ($user->document_status == "incomplete")
                                <span class="ml-1 badge badge-dark">BELUM DIISI</span>
                            @endif
                        @endif
                    @endif
                @endif
            </div>

            <div class="card-body">
		        <div class="table-responsive">
		        	<table id="t_users" class="table table-bordered table-striped">
		        		<thead>
		        			<tr>
		        				<th width="5%">#</th>
		        				<th width="50%">Nama Berkas</th>
		        				<th width="25%">Tindakan</th>
		        			</tr>
                        </thead>
                        <tbody>
		        			@forelse ($user->documents as $document)
								<tr>
								    <td align="center">{{ $loop->iteration }}</td>
								    <td>{{ $document->name }}</td>
								    <td align="center">
								    	<a href="{{ url("/client_documents/{$user->id}/{$document->loc}") }}" target="_blank" type="button" class="btn btn-warning btn-sm m-1 b_show"><i class="fas fa-search mr-2"></i>Lihat Berkas</a>
								    	<a href="{{ url("/client_documents/{$user->id}/{$document->loc}") }}" download="{{ $document->name }}.{{ $document->ext }}" type="button" class="btn btn-success btn-sm m-1 b_download"><i class="fas fa-download mr-2"></i>Unduh Berkas</a>
                                        <button class="btn btn-primary btn-sm b_edit m-1" data-name="{{ $document->name }}" data-document="{{ $document->id }}" data-identity="{{ $user->id }}"><i class="fas fa-pencil-alt mr-2"></i>Ubah Nama</button>
                                        <button class="btn btn-danger btn-sm b_remove m-1" data-document="{{ $document->id }}" data-identity="{{ $user->id }}"><i class="fas fa-trash mr-2"></i>Hapus</button>
								    </td>
								</tr>
                            @empty
		        			@endforelse
						</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

	<div id="creator" class="card" style="display: none;">
        <div class="card-header">
            <i class="fas fa-plus mr-2"></i>Tambah Berkas
        </div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
				@method('POST')
				@csrf
                <input type="file" id="fc_file" name="fc_file" class="file" accept="*">
				<label for="fc_file">Pilih Dokumen</label>
				<div class="input-group">
					<input type="text" class="form-control mb-3" disabled placeholder="Unggah Dokumen ..." id="file">
					<div class="input-group-append">
						<button type="button" class="browse btn btn-primary mb-3">Cari ...</button>
					</div>
				</div>

                <div class="form-group">
                    <label for="fc_name">Nama Dokumen</label>
                    <input type="text"
                      class="form-control" name="fc_name" id="fc_name">
                </div>

				<button type="button" class="btn btn-danger mt-3 mr-3 b_cancel"><i class="fa fa-times mr-2"></i>Batal</button>
				<button type="submit" class="btn btn-success mt-3 b_save"><i class="fa fa-save mr-2"></i>Simpan</button>
			</form>
        </div>
    </div>

	<div id="remover" style="display: none;">
		<form method="post" action="" id="f_remover">
			@method('DELETE')
			@csrf
		</form>
	</div>

	<div id="acceptor" style="display: none;">
		<form action="{{ url("/admin/documents/{$user->id}/accept") }}" method="post" action="" id="f_acceptor">
			@method('PUT')
			@csrf
            <input type="hidden" name="fa_message" id="fa_message">
		</form>
	</div>

	<div id="rejector" style="display: none;">
		<form action="{{ url("/admin/documents/{$user->id}/reject") }}" method="post" action="" id="f_rejector">
			@method('PUT')
			@csrf
            <input type="hidden" name="fr_message" id="fr_message">
		</form>
	</div>

	<div id="messenger" style="display: none;">
		<form action="{{ url("/admin/documents/{$user->id}/message") }}" method="post" action="" id="f_messenger">
			@method('PUT')
			@csrf
            <input type="hidden" name="fm_message" id="fm_message">
		</form>
	</div>

    <div id="editor" class="card" style="display: none;">
        <div class="card-header">
            <i class="fas fa-pencil-alt mr-2"></i>Ubah Nama Berkas
        </div>
        <div class="card-body">
            <form method="post" action="" id="f_editor">
				@method('PUT')
				@csrf
		    	<input class="form-control fe_name" value="" name="fe_name">
				<button type="button" class="btn btn-danger mt-3 mr-3 b_cancel"><i class="fa fa-times mr-2"></i>Batal</button>
				<button type="submit" class="btn btn-success mt-3"><i class="fa fa-save mr-2"></i>Simpan</button>
			</form>
        </div>
    </div>

    <script type="text/javascript">
		$(document).ready(function(){
			$("#t_users").DataTable({
				"columns": [
					{ orderable: true },
					{ orderable: true },
					{ orderable: false }
				],
				"language": {
					"lengthMenu"	: "Menampilkan _MENU_ dokumen per halaman",
					"emptyTable"	: "Masih belum ada dokumen yang ditambahkan.",
					"zeroRecords"	: "Dokumen yang dicari tidak ditemukan.",
					"info"			: "Halaman _PAGE_ dari _PAGES_",
					"infoEmpty"		: "Tidak ada dokumen yang ditemukan.",
					"infoFiltered"	: "(disaring dari total _MAX_ dokumen)",
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
			})
		})

        $(document).on("click", ".browse", function() {
			var file = $(this).parents().find(".file")
			file.trigger("click")
		})
		$('input[type="file"]').change(function(e) {
			var fileName = e.target.files[0].name
			$("#file").val(fileName)
			$("#fc_name").val(fileName.split(".")[0])
		})

        $("#b_create").click(function() {
            $("#content").slideUp()
            $("#creator").slideDown()
        })

		$(".b_cancel").click(function(){
			$("#content").slideDown()
			$(this).parent().parent().parent().slideUp();
		})

        $(".b_save").click(function(){
			let dis = $(this);
			setTimeout(function(){
				dis.prop('disabled', true);
			},50);
			dis.html('<i class="spinner-border spinner-border-sm mr-2"></i>Menyimpan ...')
			dis.parent().children(".b_cancel").prop("disabled", true);
		})

        $(".b_remove").click(function(){
			let id = $(this).data('identity');
			let doc = $(this).data('document');
			let remove = confirm('Yakin ingin menghapus dokumen ini?')
			if (remove == true) {
			    $("#f_remover").attr('action', '{{ url("admin/documents") }}/' + id + '/' + doc);
				$("#f_remover").submit();
			}
		});

        $(".b_edit").click(function(){
			let id = $(this).data('identity');
			let doc = $(this).data('document');
			let name = $(this).data('name');
			$("#f_editor").attr('action', '{{ url("admin/documents") }}/' + id + '/' + doc);
			$("#f_editor").children(".fe_name").val(name);
			$("#content").slideUp();
			$("#editor").slideDown();
		});

        $("#b_accept").click(function() {
            let msg = prompt("Yakin ingin menerima berkas-berkasnya?\nPesan:", "-")
            if (msg) {
                $("#fa_message").val(msg)
				$("#f_acceptor").submit()
            }
        })

        $("#b_reject").click(function() {
            let msg = prompt("Yakin ingin menolak berkas-berkasnya?\nPesan:", "-")
            if (msg) {
                $("#fr_message").val(msg)
				$("#f_rejector").submit()
            }
        })

        $("#b_message").click(function() {
            let msg = prompt("Kirim pesan perihal berkas ke klien\nPesan:")
            if (msg) {
                $("#fm_message").val(msg)
				$("#f_messenger").submit()
            }
        })
    </script>
@endsection
