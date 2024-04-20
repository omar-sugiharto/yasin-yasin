<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="Fathul Husnan, Omar Abiyoso Sugiharto" />
        <title>
            Admin - @yield('title')
        </title>

        <link href="{{ asset('css/admin.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/admin-custom.css') }}" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.0/main.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>

        @yield('addcss')
        @yield('addjs')
    </head>

    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">

            <a class="navbar-brand" href="{{ url('/admin/') }}">Yasin & Yasin</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>

            <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="{{ url('/profil/') }}">Profil</a>
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>

        <div id="layoutSidenav">

            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">

                        <div class="nav">

                            <div class="sb-sidenav-menu-heading">Menu</div>

                            <a class="nav-link" href="{{ url('/') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                                Beranda
                            </a>

                            <a class="nav-link" href="{{ url('/admin/') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dasbor
                            </a>


                            <a class="nav-link" href="{{ url('/admin/cp') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-layer-group"></i></div>
                                Company Profile
                            </a>

                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseGallery" aria-expanded="false" aria-controls="collapseGallery">
                                <div class="sb-nav-link-icon"><i class="fas fa-images"></i></div>
                                Galeri
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseGallery" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{ url('/admin/images') }}">Daftar Gambar</a>
                                    <a class="nav-link" href="{{ url('/admin/images/trash') }}">Tempat Sampah</a>
                                </nav>
                            </div>

                            <a class="nav-link" href="{{ url('/admin/attachments') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-paperclip"></i></div>
                                Lampiran
                            </a>

                            <a class="nav-link" href="{{ url('/admin/schedules') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-calendar-alt"></i></div>
                                Kalender
                                @if ($total['booked'])
                                    <span class="badge badge-danger ml-2">{{ $total['booked'] }}</span>
                                @endif
                            </a>

                            <a class="nav-link" href="{{ url('/admin/reports') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                                Laporan Audit
                            </a>

                            <a class="nav-link" href="{{ url('/admin/infos') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-info"></i></div>
                                Informasi Situs
                            </a>

                            <a class="nav-link" href="{{ url('/admin/users') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Pengguna
                            </a>

                            <a class="nav-link" href="{{ url('/admin/documents') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-copy"></i></div>
                                Berkas Klien
                                @if ($total['waiting'])
                                    <span class="badge badge-danger ml-2">{{ $total['waiting'] }}</span>
                                @endif
                            </a>

                            {{-- Tambah Menu Lagi Nanti --}}

                        </div>

                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Masuk sebagai:</div>
                        {{ Auth::user()->name }}
                    </div>
                </nav>
            </div>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">@yield('title')</h1>

                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"> <a href="{{ url('/') }}">Beranda</a>&nbsp;/&nbsp;<a href="{{ url('/admin/') }}">Ruang Admin</a>&nbsp;/ @yield('breadcrumb')</li>
                        </ol>

                        @yield('content')
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Yasin & Yasin 2020</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/scripts.js') }}"></script>

    </body>
</html>
