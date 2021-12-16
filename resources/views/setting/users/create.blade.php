@extends('layouts.app')

@section('content')
  
<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box page-title-box-alt">
                <h4 class="page-title"> {{ trans('User Management') }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('setting.users.index') }}" class="nav-link" ><i class="fe-arrow-left"></i> {{ trans('global.btn_back') }}</a>
                    <hr>
                    {!! Form::open([
                        'method' => 'POST', 
                        'route' => ['setting.users.store'],
						'files' => true,
                    ]) !!}


                        <div class="alert alert-info">
                            <b>INFORMASI</b> <br> 
                            - Default Password: 123456, Silahkan instruksikan user untuk mengganti password setelah akun user dibuat. <br>
                        </div>

                        <div class="form-group row mt-4">
                            {!! Form::label('name', 'Name', ['class' => 'col-form-label text-end col-sm-3']) !!}
                            <div class="col-sm-6">
                                {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '','id' => 'name']) !!}
                                <p class="help-block"></p>
                                @if($errors->has('name'))
                                    <p class="help-block">
                                        {{ $errors->first('name') }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-end"></label>
                            <div class="col-sm-3">
                                <label>Username<span class="text-danger">*</span></label>
                                {!! Form::text('username', old('username'), ['class' => 'form-control', 'placeholder' => '', 'required' => '','id' => 'username']) !!}
                                <p class="help-block"></p>
                                @if($errors->has('username'))
                                    <p class="help-block">
                                        {{ $errors->first('username') }}
                                    </p>
                                @endif
                            </div>
                            <div class="col-sm-3">
                                <label>Email<span class="text-danger">*</span></label>
                                {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => '', 'required' => '','id' => 'email']) !!}
                                <p class="help-block"></p>
                                @if($errors->has('email'))
                                    <p class="help-block">
                                        {{ $errors->first('email') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-end"></label>
                            <div class="col-sm-4">
                                <label>Roles<span class="text-danger">*</span></label>
                                {!! Form::select('roles[]', $roles, old('roles'), ['class' => 'form-control select2', 'multiple' => 'multiple', 'required' => '']) !!}
                                <p class="help-block"></p>
                                @if($errors->has('roles'))
                                    <p class="help-block">
                                        {{ $errors->first('roles') }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-end">Photo Profile</label>
                            <div class="col-sm-8">
                                <input type="file" name="image_url" id="profile-img">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-end"></label>
                            <div class="col-sm-4">
                                <img src="" id="profile-img-tag" width="200px" />
                            </div>
                        </div>
                        <hr>
                        <div class="row form-group">
                            <div class="col-sm-12">
                                <a href="{{ route('setting.users.index') }}" class="btn btn-light float-end mr-2 ">{{ trans('global.btn_cancel') }}</a>
                                {!! Form::submit(trans('global.btn_submit'), ['class' => 'btn btn-danger float-end']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@stop

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
