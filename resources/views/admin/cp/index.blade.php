@extends('templates.admin')

@section('title')
	Company Profile
@endsection

@section('breadcrumb')
	Company Profile
@endsection

@section('content')
    <div id="content">
        <a href="{{ url('/admin/cp/create') }}" id="b_create" class="btn btn-info mb-4"><i class="fa fa-plus mr-2"></i>Tambah Bagian</a>
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
                <i class="fas fa-layer-group mr-2"></i>Daftar Bagian Company Profile
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="t_cp" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="30%">Judul</th>
                                <th width="25%">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach ($cp as $section)
                                @if ($section->slug == "vimision")
                                    @if ($section->title == "Visi")
                                        <tr>
                                            <td align="center">{{ $i }}</td>
                                            <td>Visi & Misi</td>
                                            <td align="center">
                                                <a href="{{ url('/admin/cp').'/'.$section->slug }}" type="button" class="btn btn-primary btn-sm m-1 b_edit"><i class="fa fa-pencil-alt mr-2"></i>Ubah</a>
                                            </td>
                                        </tr>
                                        @php $i++; @endphp
                                    @endif
                                @else
                                    <tr>
                                        <td align="center">{{ $i }}</td>
                                        <td>{{ $section->title }}</td>
                                        <td align="center">
                                            @if ($i > 3)
                                                <button type="button" class="btn btn-info btn-sm m-1" onclick="getElementById('f_up_{{ $section->id }}').submit()"><i class="fa fa-arrow-up mr-2"></i>Naikkan</button>
                                            @endif
                                            @if ($i > 2 && $i < count($cp) - 1)
                                                <button type="button" class="btn btn-info btn-sm m-1" onclick="getElementById('f_down_{{ $section->id }}').submit()"><i class="fa fa-arrow-down mr-2"></i>Turunkan</button>
                                            @endif
                                            <a href="{{ url('/admin/cp').'/'.$section->slug }}" type="button" class="btn btn-primary btn-sm m-1 b_edit"><i class="fa fa-pencil-alt mr-2"></i>Ubah</a>
                                            @if ($i > 2)
                                                <button type="button" class="btn btn-danger btn-sm m-1 b_remove" data-identity="{{ $section->id }}"><i class="fa fa-times mr-2"></i>Hapus</button>
                                                <form method="post" action="{{ url('/admin/cp').'/'.$section->slug }}" id="f_remove_{{ $section->id }}">
                                                    @method('delete')
                                                    @csrf
                                                    <input type="hidden" value="{{ $section->slug }}">
                                                </form>
                                            @endif

                                            <form method="post" action="{{ url('/admin/cp').'/'.$section->slug."/up" }}" id="f_up_{{ $section->id }}">
                                                @csrf
                                                <input type="hidden" value="{{ $section->slug }}">
                                            </form>
                                            <form method="post" action="{{ url('/admin/cp').'/'.$section->slug."/down" }}" id="f_down_{{ $section->id }}">
                                                @csrf
                                                <input type="hidden" value="{{ $section->slug }}">
                                            </form>
                                        </td>
                                    </tr>
                                    @php $i++; @endphp
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
		$(document).ready(function(){
			$("#t_cp").DataTable({
				"columns": [
					{ orderable: true },
					{ orderable: true },
					{ orderable: false }
				],
				"language": {
					"lengthMenu"	: "Menampilkan _MENU_ bagian company profile per halaman",
					"emptyTable"	: "Masih belum ada bagian company profile yang dibuat.",
					"zeroRecords"	: "Bagian company profile yang dicari tidak ditemukan.",
					"info"			: "Halaman _PAGE_ dari _PAGES_",
					"infoEmpty"		: "Tidak ada bagian company profile yang ditemukan.",
					"infoFiltered"	: "(disaring dari total _MAX_ bagian company profile)",
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

        $(".b_remove").click(function(e) {
            if (confirm("Yakin ingin menghapus bagian ini?")) {
                let identity = $(this).data('identity')
                $("#f_remove_" + identity).submit()
            }
        })
    </script>
@endsection
