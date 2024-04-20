@extends('templates.main')

@section('title')
    Dokumen Pendukung
@endsection

@section('content')
<section class="hero-wrap container">
    <div class="container-fluid px-0">
        <div class="row d-md-flex no-gutters slider-text slider-title align-items-center justify-content-end">
            <div class="one-forth align-items-center ftco-animate">
                <div class="title mt-5">
                    <center><h2>Dokumen Pendukung</h2></center>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container mb-5">
    <div class="container-fluid px-0">
        <div class="row d-md-flex no-gutters slider-text slider-title align-items-center">
            <div class="one-forth align-items-center ftco-animate">
                <div class="row text-center text-lg-left">
					@foreach ($attachment as $attach)
						<div class="col-lg-3 col-md-4 col-6">
				    			<label for="attach{{ $loop->iteration }}">{{ $attach->name }}</label><br>
								<a href="{{ url('images/user_upload/'.$attach->name.'｜'.$attach->id.$attach->ext) }}" target="_blank"><img src="{{ asset('images/user_upload/'.$attach->name.'｜'.$attach->id.$attach->ext) }}" class="img-thumbnail mb-3" style="cursor: zoom-in;"></a>
						    </div>
					@endforeach
				</div>
            </div>
        </div>
    </div>
</section>

@endsection
