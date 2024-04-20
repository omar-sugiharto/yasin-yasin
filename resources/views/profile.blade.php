@extends('templates.main')

@section('title')
    Profil
@endsection

@section('content')
<section class="hero-wrap container">
    <div class="container-fluid px-0">
        <div class="row d-md-flex no-gutters slider-text slider-title align-items-center justify-content-end">
            <div class="one-forth align-items-center ftco-animate">
                <div class="title mt-5">
                    <center><h2>Profil</h2></center>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container mb-5">
    <div class="row">
        <div class="col-12">

            <div class="row">
                <div class="col-6">

                    <div class="card mb-5 ftco-animate">
                        <div class="card-header">
                            <i class="fa fa-user mr-2"></i>Detail Profil
                        </div>
                        <div class="card-body">
                            @if (session('profileMessage'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('profileMessage') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span class="fa fa-times"></span>
                                    </button>
                                </div>
                            @endif
                            <form method="post">
                                @method('PUT')
                                @csrf
                                <div class="form-group">
                                    <label for="f_name">Nama</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="f_name" name="name" value="{{ old('name') ?? Auth::user()->name }}" required autocomplete="name" autofocus aria-describedby="nameHelp">
                                    @error('name')
                                        <small id="nameHelp" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="f_address">Alamat</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="f_address" name="address" value="{{ old('address') ?? Auth::user()->address }}" required autocomplete="address" aria-describedby="addressHelp">
                                    @error('address')
                                        <small id="addressHelp" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="f_email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="f_email" name="email" value="{{ old('email') ?? Auth::user()->email }}" required autocomplete="email" aria-describedby="emailHelp">
                                    @error('email')
                                        <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group f_conf" @error('password') @else style="display: none;" @enderror>
                                    <label for="f_password">Konfirmasi Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="f_password" name="password" required autocomplete="password" aria-describedby="passwordHelp">
                                    @error('password')
                                        <small id="passwordHelp" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-success mt-2" disabled><i class="fa fa-save mr-2"></i>Simpan</button>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="col-6">
                    <div class="card mb-5 ftco-animate">
                        <div class="card-header">
                            <i class="fa fa-key mr-2"></i>Atur Ulang Kata Sandi
                        </div>
                        <div class="card-body">
                            @if (session('passwordMessage'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('passwordMessage') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span class="fa fa-times"></span>
                                    </button>
                                </div>
                            @endif
                            <form method="post">
                                @method('PUT')
                                @csrf
                                <div class="form-group">
                                    <label for="f_current_password">Password Saat Ini</label>
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="f_current_password" name="current_password" required autocomplete="current_password" aria-describedby="current_passwordHelp">
                                    @error('current_password')
                                        <small id="current_passwordHelp" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="f_new_password">Password Baru</label>
                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="f_new_password" name="new_password" required autocomplete="new_password" aria-describedby="new_passwordHelp">
                                    @error('new_password')
                                        <small id="new_passwordHelp" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="f_new_password_confirmation">Ulangi Password Baru</label>
                                    <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" id="f_new_password_confirmation" name="new_password_confirmation" required autocomplete="new_password_confirmation" aria-describedby="new_password_confirmationHelp">
                                    @error('new_password_confirmation')
                                        <small id="new_password_confirmationHelp" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-success mt-2" disabled><i class="fa fa-save mr-2"></i>Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-6">
                    <div class="card mb-5 ftco-animate">
                        <div class="card-header">
                            <i class="fa fa-camera mr-2"></i>Foto / Logo Perusahaan
                        </div>
                        <div class="card-body">
                            @if (session('photoMessage'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('photoMessage') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span class="fa fa-times"></span>
                                    </button>
                                </div>
                            @endif

                            <form method="post" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf

                                <input type="file" id="fp_img" name="img" class="file" style="display: none;" accept="image/*">
                                <label for="fp_img">Pilih Foto / Logo</label>
                                <div class="input-group">
                                    <input type="text" class="form-control mb-3" disabled placeholder="Unggah Foto / Logo ...">
                                    <div class="input-group-append">
                                        <button type="button" class="browse btn btn-primary mb-3">Cari ...</button>
                                    </div>
                                </div>

                                <label>Pratinjau</label>
                                <div class="preview">
                                    <img src="{{ asset('images/user_photo') }}{{ (Auth::user()->photo_ext == NULL) ? '/0.png' : '/' . Auth::user()->id . Auth::user()->photo_ext }}" class="img-thumbnail mb-3" width="300px">
                                </div>

                                @if (Auth::user()->photo_ext == NULL)
                                    <button type="submit" class="btn btn-success save mt-2" disabled><i class="fa fa-save mr-2"></i>Simpan</button>
                                @else
                                    <button type="submit" class="btn btn-success save mt-2 mr-2" disabled><i class="fa fa-refresh mr-2"></i>Ganti Foto / Logo</button>
                                    <button type="submit" class="btn btn-danger mt-2" name="remove_photo" value="remove"><i class="fa fa-trash mr-2"></i>Hapus Foto / Logo</button>
                                @endif

                            </form>

                        </div>
                    </div>
                </div>

                <div id="kontak"></div>

                <div class="col-6">
                    <div class="card mb-5 ftco-animate">
                        <div class="card-header">
                            <i class="fa fa-phone mr-2"></i>Kontak
                        </div>
                        <div class="card-body">
                            @if (session('contactsMessage'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('contactsMessage') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span class="fa fa-times"></span>
                                    </button>
                                </div>
                            @endif
                            @if (session('contactsError'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('contactsError') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span class="fa fa-times"></span>
                                    </button>
                                </div>
                            @endif
                            <button id="b_create_contact" class="btn btn-primary mt-2 mr-2"><i class="fa fa-plus mr-2"></i>Tambah Kontak</button>

                            <div class="border p-3 mt-3" style="display: none;" id="f_create_contact">
                                <form action="{{ url('profil/contact') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group">
                                        <label for="contact_name">Nama Kontak</label>
                                        <input type="text" class="form-control @error('contact_name') is-invalid @enderror" id="contact_name" name="contact_name" required autocomplete="contact_name" autofocus aria-describedby="contact_nameHelp">
                                        @error('contact_name')
                                            <small id="contact_nameHelp" class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="contact_value">Isi</label>
                                        <input type="text" class="form-control @error('contact_value') is-invalid @enderror" id="contact_value" name="contact_value" required autocomplete="contact_value" autofocus aria-describedby="contact_valueHelp">
                                        @error('contact_value')
                                            <small id="contact_valueHelp" class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-success save mt-2 mr-2" disabled><i class="fa fa-save mr-2"></i>Simpan</button>
                                    <button class="btn btn-danger" id="b_cancel_contact"><i class="fa fa-arrow-left mr-2"></i>Batal</button>
                                </form>
                            </div>

                            <div class="list-group mt-3">
                                @foreach (auth()->user()->contacts as $contact)
                                    <div class="list-group-item list-group-item-action">
                                        <small class="font-weight-bold">{{ $contact->name }}</small>
                                        <p class="m-0">{{ $contact->value }}</p>
                                        <button type="button" class="btn btn-primary btn-sm mr-1 mt-2 b_edit_contact" data-contact="{{ $contact->id }}" data-name="{{ $contact->name }}" data-value="{{ $contact->value }}"><i class="fa fa-pencil-square-o"></i> Ubah</button>
                                        @if ($contact->name != "Telepon")
                                            <button type="button" class="btn btn-danger btn-sm mt-2 b_remove_contact" data-contact="{{ $contact->id }}"><i class="fa fa-trash"></i> Hapus</button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (auth()->user()->role == "client")
                <div id="pemberkasan"></div>

                <div class="card mb-5 ftco-animate">
                    <div class="card-header">
                        <i class="fa fa-copy mr-2"></i>Pemberkasan
                        @if (auth()->user()->document_status == 'incomplete')
                            <span class="badge badge-dark">BELUM DIISI</span>
                        @else
                            @if (auth()->user()->document_status == 'accepted')
                                <span class="badge badge-success">DISETUJUI</span>
                            @else
                                @if (auth()->user()->document_status == 'waiting')
                                    <span class="badge badge-warning">MENUNGGU PERSETUJUAN</span>
                                @else
                                    @if (auth()->user()->document_status == 'rejected')
                                        <span class="badge badge-danger">DITOLAK</span>
                                    @endif
                                @endif
                            @endif
                        @endif
                    </div>
                    <div class="card-body">
                        @if (auth()->user()->document_notes)
                            <div class="alert alert-warning" role="alert">
                                {{ auth()->user()->document_notes }}
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
                        <button id="b_create_doc" class="btn btn-primary mt-2 mr-2"><i class="fa fa-plus mr-2"></i>Tambah Berkas</button>

                        <div class="border p-3 mt-3" style="display: none;" id="f_create_doc">
                            <form action="{{ url('profil/doc') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <input type="file" id="fc_file" name="fc_file" class="file" style="display: none;" accept="*">
                                <label for="fc_file">Pilih Berkas</label>
                                <div class="input-group">
                                    <input type="text" class="form-control mb-3" disabled placeholder="Unggah Berkas ...">
                                    <div class="input-group-append">
                                        <button type="button" class="browse btn btn-primary mb-3">Cari ...</button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="fc_name">Nama Berkas</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="fc_name" name="fc_name" required autocomplete="fc_name" autofocus aria-describedby="fc_nameHelp">
                                    @error('fc_name')
                                        <small id="fc_nameHelp" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-success save mt-2 mr-2" disabled><i class="fa fa-upload mr-2"></i>Unggah Berkas</button>
                                <button class="btn btn-danger" id="b_cancel_doc"><i class="fa fa-arrow-left mr-2"></i>Batal</button>
                            </form>
                        </div>
                        <div class="row">
                            <div class="table-responsive mt-3 px-3 mb-0">
                                <table id="t_users" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="30%">Nama Berkas</th>
                                            <th width="65%">Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse (auth()->user()->documents as $document)
                                            <tr>
                                                <td align="center">{{ $loop->iteration }}</td>
                                                <td>{{ $document->name }}</td>
                                                <td align="center">
                                                    <a href="{{ url("/client_documents/".auth()->user()->id."/{$document->loc}") }}" target="_blank" type="button" class="btn btn-warning btn-sm m-1 b_show_doc"><i class="fa fa-search mr-2"></i>Lihat Berkas</a>
                                                    <a href="{{ url("/client_documents/".auth()->user()->id."/{$document->loc}") }}" download="{{ $document->name }}.{{ $document->ext }}" type="button" class="btn btn-success btn-sm m-1 b_download_doc"><i class="fa fa-download mr-2"></i>Unduh Berkas</a>
                                                    <button class="btn btn-primary btn-sm b_edit_doc m-1" data-name="{{ $document->name }}" data-document="{{ $document->id }}" data-identity="{{ auth()->user()->id }}"><i class="fa fa-edit mr-2"></i>Ubah Nama</button>
                                                    <button class="btn btn-danger btn-sm b_remove_doc m-1" data-document="{{ $document->id }}" data-identity="{{ auth()->user()->id }}"><i class="fa fa-trash mr-2"></i>Hapus</button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" align="center">Belum ada berkas yang diunggah.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            @endif

        </div>
    </div>
</section>

<form method="post" style="display: none" id="f_edit_doc">
    @csrf
    @method("PUT")
    <input type="hidden" id="fe_name" name="fe_name" value="">
</form>

<form method="post" style="display: none" id="f_remove_doc">
    @csrf
    @method("DELETE")
</form>

<form method="post" style="display: none" id="f_edit_contact">
    @csrf
    @method("PUT")
    <input type="hidden" id="cfe_name" name="contact_name" value="">
    <input type="hidden" id="cfe_value" name="contact_value" value="">
</form>

<form method="post" style="display: none" id="f_remove_contact">
    @csrf
    @method("DELETE")
</form>

<script type="text/javascript">
    $("input").keypress(function(){
        $(this).parent().parent().children(".f_conf").slideDown();
        $(this).parent().parent().children(".btn").prop("disabled", false);
    });

    $('.browse').click(function(){
        $(this).parent().parent().parent().children('.file').trigger("click");
    });
    $('input[type="file"]').change(function(e) {
        var fileName = e.target.files[0].name;
        var dis = $(this);
        dis.parent().children(".input-group").children('input[type="text"]').val(fileName);

        var profile = $(this).parent().children(".save");
        var documents = $(this).parent().parent().parent().children(".save");

        if (profile.length != 0) {
            profile.prop('disabled', false);
        }
        else {
            documents.prop('disabled', false);
        }
    });

    $("#b_create_doc").click(function() {
        $("#f_create_doc").slideDown();
    })

    $("#b_create_contact").click(function() {
        $("#f_create_contact").slideDown();
    })

    $("#b_cancel_doc").click(function(e) {
        e.preventDefault();
        $("#f_create_doc").slideUp();
    })

    $("#b_cancel_contact").click(function(e) {
        e.preventDefault();
        $("#f_create_contact").slideUp();
    })

    $(".b_edit_doc").click(function() {
        let doc = $(this).data('document')
        let name = $(this).data('name')
        let newName = prompt("Masukkan nama berkas:", name)
        if (newName) {
            $("#fe_name").val(newName)
            $("#f_edit_doc").attr('action', '{{ url("profil/doc") }}/' + doc)
            $("#f_edit_doc").submit()
        }
    })

    $(".b_remove_doc").click(function() {
        let doc = $(this).data('document')
        let name = $(this).data('name')
        let conf = confirm("Yakin ingin menghapus berkas ini?")
        if (conf) {
            $("#f_remove_doc").attr('action', '{{ url("profil/doc") }}/' + doc)
            $("#f_remove_doc").submit()
        }
    })


    $(".b_edit_contact").click(function() {
        let contact = $(this).data('contact')
        let name = $(this).data('name')
        let value = $(this).data('value')
        let newName = name
        if (name != "Telepon") {
            newName = prompt("Masukkan nama kontak:", name)
        }
        if (newName) {
            let newValue = prompt("Masukkan isi kontak:", value)
            if (newValue) {
                $("#cfe_name").val(newName)
                $("#cfe_value").val(newValue)
                $("#f_edit_contact").attr('action', '{{ url("profil/contact") }}/' + contact)
                $("#f_edit_contact").submit()
            }
        }
    })

    $(".b_remove_contact").click(function() {
        let contact = $(this).data('contact')
        let name = $(this).data('name')
        let conf = confirm("Yakin ingin menghapus kontak ini?")
        if (conf) {
            $("#f_remove_contact").attr('action', '{{ url("profil/contact") }}/' + contact)
            $("#f_remove_contact").submit()
        }
    })
</script>

@endsection
