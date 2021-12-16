
        
        <div class="form-group row">
            <label class="col-sm-3 col-form-label text-end">Code <span class="text-danger">*</span></label>
            <div class="col-sm-2">
                {!! Form::text('code', old('code'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('code'))
                    <p class="help-block">
                        {{ $errors->first('code') }}
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-form-label text-end">Name <span class="text-danger">*</span></label>
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
            <label class="col-sm-3 col-form-label text-end">Status <span class="text-danger">*</span></label>
            <div class="col-sm-6">
                <input type="checkbox" name="status" data-plugin="switchery" class="switchery switchery-small" data-color="#039cfd"  value="{{ $items->status ?? '0' }}" id="switchery" />
                <p class="help-block"></p>
                @if($errors->has('status'))
                    <p class="help-block">
                        {{ $errors->first('status') }}
                    </p>
                @endif
            </div>
        </div>
        
        <hr>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label text-end"></label>
            <div class="col-sm-8">
                <a href="{{ route('master.area.index') }}" class="btn btn-light text-uppercase">{{ trans('global.btn_cancel') }}</a>
                {!! Form::submit(trans('global.btn_submit'), ['class' => 'btn btn-danger text-uppercase','id' => 'btn-submit']) !!}
            </div>
        </div>
        
        @section('js')
            <script>
                $(document).ready(function() {
                    if($('#switchery').val()=='1'){
                        $('#switchery').click();
                    }
                    $( ".switchery" ).on( "change", function() {
                        if( $( this ).prop('checked') ) {
                            $( this ).attr('value', '1');
                        }else{
                            $( this ).attr('value', '0');
                        }
                    });
                });
            </script>
        @stop