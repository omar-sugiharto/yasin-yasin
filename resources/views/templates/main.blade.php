<!DOCTYPE html>
<html lang="en">

	<head>
		<title>KJA Yasin & Yasin - @yield('title')</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="{{ asset('css/animate.css') }}">
		<link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
		<link rel="stylesheet" href="{{ asset('css/flaticon.css') }}">
		<link rel="stylesheet" href="{{ asset('css/style.css') }}">
		<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        @yield('addcss')
        @yield('addjs')
	</head>

	<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

		<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar ftco-navbar-light site-navbar-target" id="ftco-navbar">
			<div class="container">
				{{-- <a class="navbar-brand" href="{{ url('/') }}"><small>Kantor Jasa Akuntansi</small> Yasin <span>&</span> Yasin</a> --}}
				<a class="navbar-brand" href="{{ url('/') }}">KJA Yasin <span>&</span> Yasin</a>
				<button class="navbar-toggler js-fh5co-nav-toggle fh5co-nav-toggle" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
					<span class="oi oi-menu"></span> Menu
				</button>

				<div class="collapse navbar-collapse" id="ftco-nav">
					<ul class="navbar-nav nav ml-auto">
						<li class="nav-item"><a href="{{ url('/') }}" class="nav-link btn btn-primary m-1"><span>Beranda</span></a></li>
						<li class="nav-item"><a href="{{ url('/testimoni') }}" class="nav-link btn btn-primary m-1"><span>Testimoni</span></a></li>

						@auth
							@if (Auth::user()->role == 'admin')
								<li class="nav-item"><a href="{{ url('/admin') }}" class="nav-link btn btn-primary m-1"><span>Admin</span></a></li>
                			@else
								<li class="nav-item"><a href="#" class="nav-link btn btn-primary m-1 b_audit"><span>Mohon Audit</span></a></li>
                			@endif


							<li class="nav-item"><a href="{{ url('/profil') }}" class="nav-link btn btn-primary m-1"><span>Profil</span></a></li>

							<li class="nav-item"><a href="{{ route('logout') }}" class="nav-link btn btn-primary m-1" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span>Keluar</span></a></li>

							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
	                            @csrf
	                        </form>

	                    @else
							<li class="nav-item"><a href="{{ route('register') }}" class="nav-link btn btn-primary m-1"><span>Daftar</span></a></li>

							<li class="nav-item"><a href="{{ route('login') }}" class="nav-link btn btn-primary m-1"><span>Masuk</span></a></li>
						@endauth
					</ul>
				</div>
			</div>
		</nav>

		@yield('content')

		<footer class="ftco-footer ftco-section">
      		<div class="container">
		        <div class="row mb-5">

					<div class="col-md">
						<div class="ftco-footer-widget mb-4">
							<h2 class="ftco-heading-2">Tentang</h2>
							<p>{{ stripslashes($cp['tentang']??'') }}</p>
							<ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
								@if(($infos['twitter']??"") != "")
									<li class="ftco-animate"><a href="{{ url($infos['twitter']) }}" target="_blank"><span class="fa fa-twitter"></span></a></li>
								@endif
								@if(($infos['facebook']??"") != "")
									<li class="ftco-animate"><a href="{{ url($infos['facebook']) }}" target="_blank"><span class="fa fa-facebook"></span></a></li>
								@endif
								@if(($infos['instagram']??"") != "")
									<li class="ftco-animate"><a href="{{ url($infos['instagram']) }}" target="_blank"><span class="fa fa-instagram"></span></a></li>
								@endif
							</ul>
						</div>
					</div>

					<div class="col-md">
						<div class="ftco-footer-widget mb-4 ml-md-4">
							<h2 class="ftco-heading-2">Navigasi</h2>
							<ul class="list-unstyled">
								<li><a href="{{ url('/') }}"><span>Beranda</span></a></li>
								<li><a href="{{ url('/testimoni') }}"><span>Testimoni</span></a></li>
								@auth
									@if (Auth::user()->role == 'admin')
										<li><a href="{{ url('/admin') }}"><span>Admin</span></a></li>
                        			@else
										<li><a href="{{ url('/kalender') }}"><span>Mohon Audit</span></a></li>
                        			@endif
									<li><a href="{{ url('/') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span>Keluar</span></a></li>
								@else
									<li class="nav-item"><a href="{{ route('login') }}"><span>Masuk</span></a></li>
									<li class="nav-item"><a href="{{ route('register') }}"><span>Daftar</span></a></li>
								@endauth

							</ul>
						</div>
					</div>

					<div class="col-md">
						<div class="ftco-footer-widget mb-4">
							<h2 class="ftco-heading-2">Punya Pertanyaan?</h2>
							<div class="block-23 mb-3">
								<ul>
									<li><a href="{{ url('https://www.google.com/maps/place/'.($infos['address']??"")) }}"><span class="icon fa fa-map-marker"></span><span class="text">{{ ($infos['address']??"")}}</span></a></li>
									<li><a href="tel://{{ $infos['phone']??"" }}"><span class="icon fa fa-phone"></span><span class="text">{{ ($infos['phone']??"") }}</span></a></li>
									<li><a href="mailto:{{ $infos['customer_service_mail']??"" }}"><span class="icon fa fa-paper-plane"></span><span class="text">{{ ($infos['customer_service_mail']??"") }}</span></a></li>
								</ul>
							</div>
						</div>
					</div>

		        </div>

				<div class="row">
					<div class="col-md-12 text-center">

					<p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
					Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
					<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>

					</div>
				</div>

      		</div>
		</footer>

		<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>

		<script src="{{ asset('js/jquery.min.js') }}"></script>
		<script src="{{ asset('js/jquery-migrate-3.0.1.min.js') }}"></script>
		<script src="{{ asset('js/popper.min.js') }}"></script>
		<script src="{{ asset('js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('js/jquery.easing.1.3.js') }}"></script>
		<script src="{{ asset('js/jquery.waypoints.min.js') }}"></script>
		<script src="{{ asset('js/jquery.stellar.min.js') }}"></script>
		<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
		<script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
		<script src="{{ asset('js/jquery.animateNumber.min.js') }}"></script>
		<script src="{{ asset('js/scrollax.min.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>

        <script>
            $(".b_audit").click(function() {
               var status = "{{ auth()->user()->document_status ?? '' }}";

               if (status == 'incomplete') {
                   alert("Harap lengkapi pemberkasan Anda sebelum melakukan permohonan Audit!");
                   window.location.href = "{{ url('/profil#pemberkasan') }}";
               }
               else if (status == 'waiting') {
                   alert("Berkas Anda sedang diperiksa, harap tunggu hingga berkas Anda disetujui, kami akan memberitahu Anda melalui email saat pemeriksaan telah selesai.");
               }
               else if (status == 'rejected') {
                   alert("Berkas yang Anda kirimkan kami tolak, harap periksa kembali berkas yang Anda kirim!");
                   window.location.href = "{{ url('/profil#pemberkasan') }}";
               }
               else if (status == 'accepted') {
                   window.location.href = "{{ url('/kalender') }}";
               }
            });
        </script>

	</body>
</html>
