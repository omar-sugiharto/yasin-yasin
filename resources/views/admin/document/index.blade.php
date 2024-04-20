@extends('templates.admin')

@section('title')
	Berkas Klien
@endsection

@section('breadcrumb')
	Berkas Klien
@endsection

@section('content')
    <div id="content">
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
        @if ($total['waiting'])
            <div class="alert alert-warning" role="alert">
                Ada {{ $total['waiting'] }} klien yang menunggu persetujuan pemberkasan.
            </div>
        @endif
        <div class="card mb-4">
		    <div class="card-header">
		        <i class="fas fa-users mr-2"></i>Daftar Klien
            </div>

            <div class="card-body">
		        <div class="table-responsive">
		        	<table id="t_users" class="table table-bordered table-striped">
		        		<thead>
		        			<tr>
		        				<th width="5%">#</th>
		        				<th width="40%">Nama Klien</th>
		        				<th width="30%">Status Berkas</th>
		        				<th width="25%">Tindakan</th>
		        			</tr>
                        </thead>
                        <tbody>
		        			@foreach ($users as $user)
								<tr>
								    <td align="center">{{ $loop->iteration }}</td>
								    <td>{{ $user->name }}</td>
								    <td align="center">
                                        @php

                                        @endphp
                                        @if ($user->document_status == "rejected")
                                            <span class="badge badge-danger">DITOLAK</span>
                                        @else
                                            @if ($user->document_status == "waiting")
                                                <span class="badge badge-warning">MENUNGGU PERSETUJUAN</span>
                                            @else
                                                @if ($user->document_status == "accepted")
                                                    <span class="badge badge-success">DISETUJUI</span>
                                                @else
                                                    @if ($user->document_status == "incomplete")
                                                        <span class="badge badge-dark">BELUM DIISI</span>
                                                    @endif
                                                @endif
                                            @endif
                                        @endif

                                    </td>
								    <td align="center">
								    	<a href="{{ url('/admin/documents/'.$user->id) }}" type="button" class="btn btn-primary btn-sm m-1"><i class="fa fa-eye mr-2"></i>Detail</a>
								    </td>
								</tr>
		        			@endforeach
						</tbody>
                    </table>
                </div>
            </div>
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
					"lengthMenu"	: "Menampilkan _MENU_ klien per halaman",
					"emptyTable"	: "Masih belum ada klien yang dibuat.",
					"zeroRecords"	: "Klien yang dicari tidak ditemukan.",
					"info"			: "Halaman _PAGE_ dari _PAGES_",
					"infoEmpty"		: "Tidak ada klien yang ditemukan.",
					"infoFiltered"	: "(disaring dari total _MAX_ klien)",
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


    </script>
@endsection
