<div class="col-lg-8">

    <div class="form-group row mb-2">
        <div class="col-sm-8">
            <div class="form-check">
                <input name='type' type='radio' class='form-check-input is_type' value='line' id='relation_line' {{  isset($item->type) ? ($item->type=='line' ? 'checked ': '' ) : 'checked' }}> 
                <label class="form-check-label" for='relation_line'>Line Production</label>
            </div>
            <div class="form-check">
                <input name='type' type='radio' class='form-check-input is_type' value='trolley' id='relation_trolley' {{  isset($item->type) ? ($item->type=='trolley' ? 'checked ': '') : '' }}> 
                <label class="form-check-label" for='relation_trolley'>Trolley</label>
            </div>
        </div>
    </div>

    <div class="form-group row mb-2">
        <div class="col-sm-3">
            <label>Device ID</label>
            {!! Form::text('device_id', old('device_id'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
            @if($errors->has('device_id'))
                <p class="help-block">
                    {{ $errors->first('device_id') }}
                </p>
            @endif
        </div>
        <div class="col-sm-7">
            <label>Name</label>
            {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
            @if($errors->has('name'))
                <p class="help-block">
                    {{ $errors->first('name') }}
                </p>
            @endif
        </div>
    </div>

    <div class="form-group row mb-2">
        <div class="col-sm-6">
            <label>Group Area</label>
            {!! Form::select('area_id', $area, old('area_id'), ['class' => 'form-control select2', 'placeholder' => '', 'required' => '']) !!}
            @if($errors->has('area_id'))
                <p class="help-block">
                    {{ $errors->first('area_id') }}
                </p>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-10">
            <label>Description</label>
            {!! Form::textarea('description', old('description'), ['class' => 'form-control', 'rows' => 3, 'placeholder' => '']) !!}
            @if($errors->has('description'))
                <p class="help-block">
                    {{ $errors->first('description') }}
                </p>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-6">
            <input type="checkbox" class="switchery" name="status" data-plugin="switchery" data-color="#039cfd" id="switchery" value="{{ $item->status ?? '0'}}"/>
            <label>Status Line</label>
            @if($errors->has('status'))
                <p class="help-block">
                    {{ $errors->first('status') }}
                </p>
            @endif
        </div>
    </div>

    <hr>

    <div class="form-group row">
        <div class="col-sm-8">
            <a href="{{ route('master.hardware.index') }}" class="btn btn-light text-uppercase mr-3">{{ trans('global.btn_cancel') }}</a>
            {!! Form::submit(trans('global.btn_submit'), ['class' => 'btn btn-danger text-uppercase','id'=>'btn-submit']) !!}
        </div>
    </div>

</div>

