<div class="row">
    <div class="col-sm-6">

        <div class="form-group row">
            <label class="col-sm-3 col-form-label text-end">Damaged Category<span class="text-danger">*</span></label>
            <div class="col-sm-8">
                {!! Form::select('category_id', $category, old('category_id'), ['class' => 'form-control select2', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('name'))
                    <p class="help-block">
                        {{ $errors->first('name') }}
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-form-label text-end">Description<span class="text-danger">*</span></label>
            <div class="col-sm-8">
                {!! Form::textarea('description', old('description'), ['class' => 'form-control', 'rows' => 3, 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('name'))
                    <p class="help-block">
                        {{ $errors->first('name') }}
                    </p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-sm-6">

        <div class="form-group row">
            <label class="col-sm-3 col-form-label text-end">Priority<span class="text-danger">*</span></label>
            <div class="col-sm-6">
                {!! Form::select('priority', $priority, old('priority'), ['class' => 'form-control select2', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('name'))
                    <p class="help-block">
                        {{ $errors->first('name') }}
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-form-label text-end">Status<span class="text-danger">*</span></label>
            <div class="col-sm-6">
                {!! Form::select('status', $status, old('status'), ['class' => 'form-control select2', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('name'))
                    <p class="help-block">
                        {{ $errors->first('name') }}
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-form-label text-end">File Attachment</label>
            <div class="col-sm-6">
                <input type="file" name="file_attachment" class="form-control">
            </div>
        </div>

    </div>
</div>



<hr>
<div class="form-group row">
    <div class="col-sm-12">
        <a href="{{ route('maintenance.index') }}" class="btn btn-light text-uppercase">{{ trans('global.btn_cancel') }}</a>
        {!! Form::submit(trans('global.btn_submit'), ['class' => 'btn btn-danger text-uppercase','id' => 'btn-submit']) !!}
    </div>
</div>

@section('js')
    <script>
        $(document).ready(function() {
      
        });
    </script>
@stop