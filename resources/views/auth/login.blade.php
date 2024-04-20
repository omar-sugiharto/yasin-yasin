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
                    <h1>Masuk</h1>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email">Alamat Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus aria-describedby="emailHelp">
                            @error('email')
                                <small id="emailHelp" class="form-text text-muted">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Kata Sandi</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required autocomplete="password" autofocus aria-describedby="passwordHelp">
                            @error('password')
                                <small id="passwordHelp" class="form-text text-muted">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Ingat Saya
                            </label>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary py-3 px-4">
                                    Masuk
                                </button>

                                <a class="btn btn-link home-link" href="{{ url('forgot') }}">
                                    Lupa kata sandi
                                </a>

                                |

                                <a class="btn btn-link home-link" href="{{ route('register') }}">
                                    Belum punya akun?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
