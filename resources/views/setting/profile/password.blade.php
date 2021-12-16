@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="page-title-box page-title-box-alt">
                    <h4 class="page-title">Pengaturan Akun</h4>
                </div>
            </div>
        </div>     

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <form class="form-horizontal" method="POST" action="{{ route('setting.profile.change_password') }}">

                            {{ csrf_field() }}
                
                        <div class="bgc-white bd bdrs-3 p-20 mB-20">
                            <h5>Form Ganti Password</h5>
                            <hr class="mB-30">
                
                            <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }} row">
                                <label for="new-password" class="col-md-4 col-form-label  text-end">Kata sandi saat ini</label>
                
                                <div class="col-md-4">
                                    <input id="current-password" type="password" class="form-control" name="current-password" required>
                
                                    @if ($errors->has('current-password'))
                                        <span class="help-block">
                                            {{ $errors->first('current-password') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                
                            <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }} row">
                                <label for="new-password" class="col-md-4 col-form-label text-end">Kata sandi baru</label>
                
                                <div class="col-md-4">
                                    <input id="new-password" type="password" class="form-control" name="new-password" required>
                
                                    @if ($errors->has('new-password'))
                                        <span class="help-block">
                                            {{ $errors->first('new-password') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                
                            <div class="form-group row">
                                <label for="new-password-confirm" class="col-md-4 col-form-label text-end">Konfirmasi kata sandi</label>
                
                                <div class="col-md-4">
                                    <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success float-right">Submit</button>
                                </div>
                            </div>
                
                        </div>
                
                    
                    </form>

                    </div>
                </div>
            </div>
        </div>


        
    </div> 
       
@endsection



