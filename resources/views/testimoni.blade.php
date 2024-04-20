@extends('templates.main')

@section('title')
    Testimoni
@endsection

@section('content')
<section class="hero-wrap container">
    <div class="container-fluid px-0">
        <div class="row d-md-flex no-gutters slider-text slider-title align-items-center justify-content-end">
            <div class="one-forth align-items-center ftco-animate">
                <div class="title mt-5">
                    <center><h2>Testimoni</h2></center>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container mb-5">
    <div class="row">
        <div class="col-12">
            <div class="card mb-5 ftco-animate">
                <div class="card-header">
                    <i class="fa fa-star mr-2"></i>Kirim Testimoni
                </div>
                <div class="card-body">
                    @if (session('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span class="fa fa-times"></span>
                            </button>
                        </div>
                    @endif
                    @guest
                        <div class="alert alert-danger mb-0">Harap masuk dengan akun Anda jika Anda berkenan memberikan testimoni terhadap pelayanan kami.</div>
                    @else
                        @if (Auth::user()->role_id == 1)
                            <div class="alert alert-danger mb-0">Admin tidak dapat memberikan testimoni.</div>
                        @else
                            <form method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="f_name">Nama</label>
                                    <input type="text" class="form-control" id="f_name" name="name" value="{{ Auth::user()->name }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="f_message">Testimoni</label>
                                    <textarea class="form-control" id="f_message" name="message" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Rating</label>
                                    <input type="hidden" id="f_rating" name="rating" value="5">
                                    <div id="star">
                                        <span class="star"><i class="fa fa-star text-warning"></i></span>
                                        <span class="star"><i class="fa fa-star text-warning"></i></span>
                                        <span class="star"><i class="fa fa-star text-warning"></i></span>
                                        <span class="star"><i class="fa fa-star text-warning"></i></span>
                                        <span class="star"><i class="fa fa-star text-warning"></i></span>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success mt-2"><i class="fa fa-paper-plane mr-2"></i>Kirim</button>
                            </form>
                        @endif
                    @endguest
                </div>
            </div>

            <div class="text-center">
                <div class="display-1" style="font-weight: bolder;">{{ $rate }}</div>
                <div style="font-size: 25px">
                    @for ($i = 0; $i < floor($rate); $i++)
                        <i class="fa fa-star text-warning"></i>
                    @endfor
                    @if (floor($rate) < $rate && ceil($rate) > $rate)
                        <i class="fa fa-star-half-o text-warning"></i>
                    @endif
                    @for ($i = 0; $i < 5 - ceil($rate); $i++)
                        <i class="fa fa-star-o"></i>
                    @endfor
                </div>
            </div>

            <div class="testimony-section">
                <div class="container">

                    <div class="row ftco-animate">
                        <div class="col-md-12">
                            <div class="carousel-testimony owl-carousel ftco-owl">

                                @foreach ($testimonials as $testimonial)
                                    <div class="item">
                                        <div class="testimony-wrap py-4">
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

            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(".star").click(function(){
        let star = $(".star");
        let idx = $(this).index();
        $("#f_rating").val(idx + 1);
        for (var i = 0; i < star.length; i++) {
            if (i <= idx) {
                star.eq(i).html('<i class="fa fa-star text-warning"></i>');
            }
            else {
                star.eq(i).html('<i class="fa fa-star-o"></i>')
            }
        }
    });
</script>
@endsection
