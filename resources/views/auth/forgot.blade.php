@extends('templates.main')

@section('title')
    Masuk
@endsection

@section('content')

<section class="hero-wrap js-fullheight">
    <div class="container-fluid px-0">
        <div class="row d-md-flex no-gutters slider-text align-items-center js-fullheight justify-content-end">
            <img class="one-third js-fullheight align-self-end order-md-last img-fluid" src="images/logo.svg" alt=""/>
            <div class="one-forth d-flex align-items-center ftco-animate js-fullheight">
                <div class="text mt-5">
                    <h1>Atur Ulang Sandi</h1>

                    @if (session('message'))
                        <label>{{ session('message') }}</label>
                    @else
                        @if (isset($token) || session('token'))
                            <form method="POST" action="{{ url('forgot') }}">
                                @method('PUT')
                                @csrf
                                <input type="hidden" name="token" value="{{ $token ?? session('token') }}">
                                <div class="form-group">
                                    <label for="password">Kata Sandi</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" autofocus aria-describedby="passwordHelp">
                                    @error('password')
                                        <small id="passwordHelp" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Ulangi Kata Sandi</label>
                                    <input type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" autofocus aria-describedby="password_confirmationHelp">
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary py-3 px-4">
                                            Atur Ulang Kata Sandi
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <form method="POST" action="{{ url('forgot') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Alamat Email</label>
                                    <input type="email" class="form-control {{ (isset($error)) ? 'is-invalid' : '' }}" name="email" value="{{ $email ?? '' }}" required autocomplete="email" autofocus aria-describedby="emailHelp">
                                    @if(isset($error))
                                        <small id="emailHelp" class="form-text text-muted">{{ $error }}</small>
                                    @endif
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary py-3 px-4">
                                            Atur Ulang Kata Sandi
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
