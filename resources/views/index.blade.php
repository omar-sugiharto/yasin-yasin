@extends('templates.main')

@section('title')
    Beranda
@endsection

@section('content')
<section class="hero-wrap js-fullheight">
    <div class="container-fluid px-0">
        <div class="row d-md-flex no-gutters slider-text align-items-center js-fullheight justify-content-end">
            <img class="one-third js-fullheight align-self-end order-md-last img-fluid" src="images/logo.svg" alt=""/>
            <div class="one-forth d-flex align-items-center ftco-animate js-fullheight">
                <div class="text mt-5">
                    <span class="subheading">Halo, @auth {{ Auth::user()->name }}@else {{ 'Pengunjung' }}@endauth! </span>
                    <h1>Selamat Datang</h1>
                    <p>{!! stripslashes($cp["tentang"]) !!}</p>
                    @auth

                        @if (Auth::user()->role == "admin")
                            <p><a href="{{ url('/admin/') }}" class="btn btn-primary py-3 px-4">Masuk Ruang Admin</a></p>
                        @else
                            <p><a href="#" class="btn btn-primary py-3 px-4 b_audit">Mohon Audit</a></p>
                        @endif

                    @else

                        <p><a href="{{ route('login') }}" class="btn btn-primary py-3 px-4">Masuk</a></p>

                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>

<!-- #Visi Misi -->

<section class="ftco-about img ftco-section" id="about-section">
    <div class="container">
        <div class="row d-flex no-gutters">
            <div class="col-md-6 col-lg-6 d-flex">
                <div class="img-about img d-flex align-items-stretch">
                    <div class="overlay"></div>
                    <div class="img d-flex align-self-stretch align-items-center" style="background-image:url(images/bg_1.jpg);">
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 pl-md-5">
                <div class="row justify-content-start pb-3">
                <div class="col-md-12 heading-section ftco-animate">
                <h2 class="mb-4">Visi & Misi</h2>
                <div class="text-about">
                    <h4>Maksud & Tujuan</h4>
                    <h4>Visi</h4>
                    {!! $cp["vision"] !!}
                    <h4>Misi</h4>
                    {!! $cp["mission"] !!}
                </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<!-- #Data Perusahaan -->
<section class="ftco-section ftco-no-pb ftco-no-pt" id="chapter-section">
    <div class="container">
        <div class="row justify-content-center py-5 mt-5">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <h2 class="mb-4">Informasi Perusahaan</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 mb-4">
                <nav id="navi">
                    <ul>
                        @foreach ($sections as $section)
                            @if ($loop->iteration > 3)
                                <li><a href="#page-{{ $loop->iteration }}">{{ $section->title }}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </nav>
            </div>

            <div class="col-md-9">
                <!-- #Bidang Usaha -->
                {{-- <div id="page-1" class= "page bg-light one">
                    <h2 class="heading">Bidang Usaha</h2>
                    <p>Pelayanan/ Jasa Yang diberikan Perusahaan:
                        <ol>
                            <li>
                                <ul>
                                    <li>Jasa Pembukuan</li>
                                    <li>Jasa Kompilasi Laporan Keuangan</li>
                                    <li>Jasa Manajemen</li>
                                    <li>Jasa Akuntansi Manajemen</li>
                                    <li>Jasa Konsultasi Manajemen</li>
                                    <li>Jasa Perpajakan</li>
                                    <li>Jasa Prosedur yang disepakati atas Informasi Keuangan</li>
                                    <li>Jasa Teknologi Informasi</li>
                                </ul>
                            </li>
                            <li>Meningkatkan pengetahuan dan keahlian Rekan Persekutuan.</li>
                            <li>Efisiensi biaya penggunaan kantor.</li>
                        </ol>
                    </p>
                </div> --}}

                @foreach ($sections as $section)
                    @if ($loop->iteration > 3)
                        <!-- #{{ $section->title }} -->
                        <div id="page-{{ $loop->iteration }}" class= "page bg-light two">
                            <h2 class="heading">{{ $section->title }}</h2>
                            {!! $section->content !!}
                        </div>
                    @endif
                @endforeach

            </div>
        </div>
    </div>
</section>

<section class="ftco-section testimony-section ftco-no-pb" id="testimonial-section">
    <div class="img img-bg border" style="background-image: url(images/bg_4.jpg);"></div>
    <div class="overlay"></div>
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-md-12 text-center heading-section heading-section-white ftco-animate">
                    <span class="subheading">Testimoni</span>
                    <h2 class="mb-3">Ini Kata Mereka Tentang Kami</h2>
                </div>
            </div>
            <div class="row ftco-animate">
                <div class="col-md-12">
                    <div class="carousel-testimony owl-carousel ftco-owl">

                        @foreach ($testimonials as $testimonial)
                            <div class="item">
                                <div class="testimony-wrap py-4">
                                    <div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-quote-left"></span></div>
                                    <div class="text">
                                        <p class="mb-4">{{ $testimonial->message }}</p>
                                        <div class="d-flex align-items-center">
                                            <div class="user-img" style="background-image: url(images/user_photo/@if($testimonial->user->photo_ext != NULL){{ $testimonial->user->id.$testimonial->user->photo_ext }})@else{{ "0.png" }}@endif"></div>
                                            <div class="pl-3">
                                                <p class="name">{{ $testimonial->user->name }}</p>
                                                <span class="position">
                                                    @for ($i = 0; $i < $testimonial->rating; $i++)
                                                        <i class="fa fa-star text-warning"></i>
                                                    @endfor
                                                    @for ($i = 0; $i < (5 - $testimonial->rating); $i++)
                                                        <i class="fa fa-star-o"></i>
                                                    @endfor
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
</section>

<section class="ftco-section contact-section ftco-no-pb mb-5" id="contact-section">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-3">
            <div class="col-md-7 heading-section text-center ftco-animate">
                <h2 class="mb-4">Hubungi Kami</h2>
                <p>Punya pertanyaan seputar layanan kami? Anda dapat menghubungi kami melalui cara-cara berikut!</p>
            </div>
        </div>

        <div class="row d-flex contact-info mb-5">
            <div class="col-md-6 col-lg-3 d-flex ftco-animate">
                <div class="align-self-stretch box text-center p-4 bg-light">
                    <div class="icon d-flex align-items-center justify-content-center">
                        <span class="fa fa-map-marker"></span>
                    </div>
                    <div>
                        <h3 class="mb-4">Alamat</h3>
                        <p><a href="{{ url('https://www.google.com/maps/place/'.$infos['address']) }}" target="_blank">{{ $infos['address'] }}</a></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 d-flex ftco-animate">
                <div class="align-self-stretch box text-center p-4 bg-light">
                    <div class="icon d-flex align-items-center justify-content-center">
                        <span class="fa fa-phone"></span>
                    </div>
                    <div>
                        <h3 class="mb-4">Telepon</h3>
                        <p><a href="tel://{{ $infos['phone'] }}">{{ $infos['phone'] }}</a></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 d-flex ftco-animate">
                <div class="align-self-stretch box text-center p-4 bg-light">
                    <div class="icon d-flex align-items-center justify-content-center">
                        <span class="fa fa-paper-plane"></span>
                    </div>
                    <div>
                        <h3 class="mb-4">Alamat Email</h3>
                        <p><a href="mailto:{{ $infos['customer_service_mail'] }}">{{ $infos['customer_service_mail'] }}</a></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 d-flex ftco-animate">
                <div class="align-self-stretch box text-center p-4 bg-light">
                    <div class="icon d-flex align-items-center justify-content-center">
                        <span class="fa fa-globe"></span>
                    </div>
                    <div>
                        <h3 class="mb-4">Situs</h3>
                        <p><a href="{{ url($infos['website']) }}">{{ $infos['website'] }}</a></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row no-gutters block-9">
            <div class="col-md-12 order-md-last d-flex">
                <form method="post" class="bg-light p-4 p-md-5 contact-form">
                    @if (session('message'))
                        <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                            {{ session('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span class="fa fa-times"></span>
                            </button>
                        </div>
                    @endif
                    @csrf
                    <div class="row">
                        <div class="form-group col-6">
                            <input type="text" class="form-control" name="name" placeholder="Nama Anda / Perusahaan" value="@auth{{ Auth::user()->name }}@endauth">
                        </div>
                        <div class="form-group col-6">
                            <input type="text" class="form-control" name="email" placeholder="Alamat Email" value="@auth{{ Auth::user()->email }}@endauth">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="subject" placeholder="Judul">
                    </div>
                    <div class="form-group">
                        <textarea name="message" id="" cols="30" rows="7" class="form-control" placeholder="Pesan"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Kirim Pesan" class="btn btn-primary py-3 px-5" @if (session('message')) autofocus @endif>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
