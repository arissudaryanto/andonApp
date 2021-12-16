<div class="form-group row">
    {!! Form::label('name', 'Name*', ['class' => 'col-form-label col-3']) !!}
    <div class="col-6">
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
    {!! Form::label('permission', 'Permissions', ['class' => 'col-form-label col-3']) !!}
    <div class="col-8">
        @if($role)
            {!! Form::select('permission[]', $permissions, old('permission') ?? $role->permissions()->pluck('name', 'name'), ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
        @else
            {!! Form::select('permission[]', $permissions, old('permission'), ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
        @endif
        <p class="help-block"></p>
        @if($errors->has('permission'))
            <p class="help-block">
                {{ $errors->first('permission') }}
            </p>
        @endif
    </div>
</div>
<hr>
<div class="form-group row">
    <div class="col-3">
    </div>
    <div class="col-8">
        <a href="{{ route('setting.roles.index') }}" class="btn btn-light text-uppercase fsz-sm">{{ trans('global.btn_cancel') }}</a>
        {!! Form::submit(trans('global.btn_submit'), ['class' => 'btn btn-danger']) !!}
    </div>
</div>