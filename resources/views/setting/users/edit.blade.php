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
					{!! Form::model($user, [
						'method' => 'PUT', 
						'files' => true,
						'route' =>  ['setting.users.update', $user->id]])
					!!}
					
						<div class="form-group row">
							{!! Form::label('name', 'Name*', ['class' => 'col-form-label text-end col-sm-3']) !!}
							<div class="col-sm-6">
							{!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
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
                                <label>Email<span class="text-danger">*</span></label>
								{!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
								<p class="help-block"></p>
								@if($errors->has('email'))
									<p class="help-block">
										{{ $errors->first('email') }}
									</p>
								@endif
							</div>
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
						</div>

						<div class="form-group row">
							{!! Form::label('roles', 'Roles*', ['class' => 'col-form-label text-end col-sm-3']) !!}
							<div class="col-sm-6">
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
							<label class="col-sm-3 col-form-label text-end">Photo Profile </label>
							<div class="col-sm-8">
                                <input type="file" name="image_url" id="profile-img">
							</div>
						</div>

						@if ($user->image_url)
							<div class="form-group row">
								<label class="col-sm-3 col-form-label text-end"> </label>
								<div class="col-sm-2">
									<img src="{{ asset('storage'.$user->image_url) }}" class="img-fluid img-thumbnail w-75" id="profile-img-exits">
								</div>
							</div>
						@endif

						<hr>
						<div class="form-group row">
							<div class="col-sm-12">
                                <a href="{{ route('setting.users.index') }}" class="btn btn-light float-end mr-2 ">{{ trans('global.btn_cancel') }}</a>
								<button type="submit" class="btn btn-danger float-end">{{ trans('global.btn_submit') }}</button>
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

			var type = $("#type");

			type.select2().on('change', function() {
				
				if(type.val() == 'Outlet' ){
					$("#outlet").show();
				}else{
					$("#outlet").hide();
				}
			});

			$("#profile-img").change(function(){
				readURL(this);
				$("#profile-img-exits").hide();
			});
		});
	</script>
@stop

 

