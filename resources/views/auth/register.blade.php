@extends('templates.main')

@section('title')
    Daftar
@endsection

@section('content')

<section class="hero-wrap js-fullheight">
    <div class="container-fluid px-0">
        <div class="row d-md-flex no-gutters slider-text align-items-center js-fullheight justify-content-end">
            <img class="one-third js-fullheight align-self-end order-md-last img-fluid" src="images/logo.svg" alt=""/>
            <div class="one-forth d-flex align-items-center ftco-animate js-fullheight">
                <div class="text mt-5">
                    <h1>Daftar</h1>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf


                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Nama Perusahaan</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus aria-describedby="nameHelp">
                                    @error('name')
                                        <small id="nameHelp" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="email">Alamat Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus aria-describedby="emailHelp">
                                    @error('email')
                                        <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="password">Kata Sandi</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" autofocus aria-describedby="passwordHelp">
                                    @error('password')
                                        <small id="passwordHelp" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Ulangi Kata Sandi</label>
                                    <input type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" autofocus aria-describedby="password_confirmationHelp">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="phone">Nomor Telepon</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus aria-describedby="phoneHelp">
                                    @error('phone')
                                        <small id="phoneHelp" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="address">Alamat Perusahaan</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address" autofocus aria-describedby="addressHelp">
                                    @error('address')
                                        <small id="addressHelp" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary py-3 px-4">
                                    Daftar
                                </button>

                                <a class="btn btn-link home-link" href="{{ route('login') }}">
                                    Sudah punya akun?
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
