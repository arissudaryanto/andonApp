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

                        {!! Form::model($users, [
                            'route' => ['setting.profile.change_profile'],
                            'method' => 'POST', 
                            'files' => true
                            ])
                        !!}
                        {{ csrf_field() }}
                
                            <h5>Form Ganti Profil</h5>
                            <hr class="mB-30">
                
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} row">
                                <label for="email" class="col-md-2 col-form-label">Name</label>
                
                                <div class="col-md-4">
                                    <input id="name" type="text" class="form-control" name="name" required value="{{ $users->name }}">
                
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            {{ $errors->first('name') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} row">
                                <label for="email" class="col-md-2 col-form-label">Email Address</label>
                
                                <div class="col-md-4">
                                    {!! Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            {{ $errors->first('email') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }} row">
                                <label for="username" class="col-md-2 col-form-label">Username</label>
                
                                <div class="col-md-4">
                                    {!! Form::text('username', old('username'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                
                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                            {{ $errors->first('username') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Photo Profile </label>
                                <div class="col-sm-4">
                                    <input type="file" name="image_url" id="profile-img" class="form-control">
                                    <img  class="img-fluid w-50 mt-2" id="profile-img-tag">
                                </div>
                            </div>

                            @if ($users->image_url)

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"> </label>
                                    <div class="col-sm-4">
                                    <img src="{{ asset('storage'.$users->image_url) }}" class="img-fluid img-thumbnail w-50" id="profile-img-exits">
                                    </div>
                                </div>
                            @endif

                            <hr>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success float-right">SUBMIT</button>
                                </div>
                            </div>

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>


        
    </div> 
       
@endsection
@section('js')
	<script type="text/javascript">
		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				
				reader.onload = function (e) {
					$('#profile-img-tag').attr('src', e.target.result);
				}
				reader.readAsDataURL(input.files[0]);
			}
		}

		$(document).ready(function() {
            $("#profile-img").change(function(){
                readURL(this);
                $("#profile-img-exits").hide();
            });
        });
</script>
@stop

