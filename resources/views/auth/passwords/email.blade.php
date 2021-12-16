@extends('layouts.auth')

@section('content')
<div class="auth-fluid">
    <!-- Auth fluid right content -->
    <div class="auth-fluid-right bg-transparent">
        <h1 class="mt-0 text-white text-center  mt-5">Error Monitoring System</h1>
        <h4 class="text-white text-center mt-4">Aplikasi manajemen kerusakan pada line production agar lebih fokus, efisien, <br> dan efektif dalam penyelesaiannya</h4>
    </div>
    <!-- end Auth fluid right content -->

    <!--Auth fluid left content -->
    <div class="auth-fluid-form-box">
        <div class="align-items-center d-flex h-100">
            <div class="card-body">
                @include('layouts.partials.messages')
                <!-- title-->
                <h4 class="mt-0">Sign In</h4>
                <p class="text-muted mb-4">Silahkan masukkan username dan password Anda.</p>

                <!-- form -->
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-2">
                        <label for="emailaddress" class="form-label">{{ trans('global.email')}} </label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="d-grid text-center">
                        <button class="btn btn-warning text-uppercase" type="submit">{{ __('Send Password Reset Link') }}
                        </button>
                    </div>
                    <div class="d-grid">
                        <a href="{{ route('login') }}" class="text-muted mt-4"><small>Kembali ke Halaman Login</small></a>
                    </div>
                </form>
                <!-- end form-->

                <!-- Footer-->
                <footer class="footer footer-alt">
                    <p class="text-muted">&copy; 2021 - Develop By <a href="https://digitalrise.id" target="_blank" class="text-primary">DigitalRISe</a></p>
                </footer>

            </div> <!-- end .card-body -->
        </div> <!-- end .align-items-center.d-flex.h-100-->
    </div>
    <!-- end auth-fluid-form-box-->
</div>

@endsection
