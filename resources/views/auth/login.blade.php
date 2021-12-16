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
            <!-- Logo -->
          
            <div class="card-body">
                @include('layouts.partials.messages')
                <!-- title-->   
                <h4 class="mt-0">Sign In</h4>
                <p class="text-muted mb-4">Silahkan masukkan username dan password Anda.</p>

                <!-- form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-2">
                        <label for="emailaddress" class="form-label">Username</label>
                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="password" class="form-label">{{ trans('global.password')}}</label>
                        <div class="input-group input-group-merge">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="input-group-text" data-password="false">
                                <span class="password-eye"></span>
                            </div>
                        </div>
                        <a href="{{ route('password.request') }}" class="text-muted float-end"><small>{{ trans('global.forgot_password')}}?</small></a>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                    <div class="d-grid text-center">
                        <button class="btn btn-warning text-uppercase" type="submit">Masuk </button>
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
