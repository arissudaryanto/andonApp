@extends('layouts.auth')

@section('content')

    <div class="account-pages py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card">
                        <div class="card-body p-4">
                            
                            <div class="text-center w-75 m-auto">
                                @if (auth()->user()->avatar != null) 
                                    <img class="rounded-circle avatar-lg img-thumbnail" src="{{ asset('storage'.auth()->user()->avatar) }}" alt="">
                                @else
                                    <img class="rounded-circle avatar-lg img-thumbnail"  src="/images/avatar.png"  />
                                @endif
                                <h4 class="text-dark-50 text-center mt-3">Hi, {{ Auth::user()->name }} </h4>
                                <p class="text-muted mb-4">Silahkan masukan password untuk membuka aplikasi kembali.</p>
                            </div>

                            <form method="POST" action="{{ route('lockscreen.store') }}" aria-label="{{ __('Locked') }}">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} mt-3 mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input class="form-control" type="password" required="" name="password" id="password" placeholder="Enter your password">
                                    @if ($errors->has('password'))
                                        <span class="form-text text-danger">
                                            <small>{{ $errors->first('password') }}</small>
                                        </span>
                                    @endif
                                </div>

                                <div class="d-grid text-center">
                                    <button class="btn btn-success" type="submit"> Log In </button>
                                </div>

                            </form>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted">Bukan Kamu? kembali <a href="{{ route('logout') }}" class="text-success fw-medium ">Masuk</a></p>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>

@endsection
