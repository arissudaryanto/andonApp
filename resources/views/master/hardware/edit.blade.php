@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box page-title-box-alt">
                <h4 class="page-title"> Hardware</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a class="float-left" href="{{ route('master.hardware.index') }}"><i class="fe-arrow-left mR-10"></i> {{ trans('global.btn_back')}} </a>
                    <hr class="mB-30">
                    {!! Form::model($item, [
                            'route' => ['master.hardware.update', $item->id],
                            'method' => 'put', 
                            'files' => true
                        ])
                    !!}

                    <div class="row justify-content-between">
                        <div class="col-lg-3">
                            <div class="form-group mb-2">
                                <label>Upload Foto</label>
                                <div class="dropzone-img mt-2">
                                    <input class="form-file" type="file" name="file">
                                    @if($item->image_url)
                                        <a class="btn btn-danger icon-lg" id="img-remove" style="display:block"><i class="fe-trash"></i></a>
                                        <div id="dropzone-img" style="display:none">Click or drop something here</div>
                                        <img src="{{ asset('storage'.$item->image_url) }}" id="img-preview" style="width:100%"/>
                                    @else
                                        <a class="btn btn-danger icon-lg" id="img-remove"><i class="fe-trash"></i></a   >
                                        <div id="dropzone-img">Click or drop something here</div>
                                        <img src="" id="img-preview" style="width:100%"/>
                                    @endif

                                </div>
                            </div>
                        </div>
                        @include('master.hardware.form')
                    </div>
                        
                    {!! Form::close() !!}
                          
                </div>
            </div>
        </div>
    </div>

</div>
	
@stop



@section('js')
    <script>
        function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$('#img-preview').attr('src', e.target.result);
				}
				reader.readAsDataURL(input.files[0]);
            }
        }

        $(document).ready(function() {
            
            var fileInput = document.querySelector('input[type=file]');
            var filenameContainer = document.querySelector('#filename');
            var dropzone = document.querySelector('div');

            fileInput.addEventListener('change', function() {
                readURL(this);
                $("#dropzone-img").hide();
                $("#img-remove").show();
            });

            fileInput.addEventListener('dragenter', function() {
                dropzone.classList.add('dragover');
            });

            fileInput.addEventListener('dragleave', function() {
                dropzone.classList.remove('dragover');
            });

            $("#img-remove").on("click", function () {
				$('#img-preview').removeAttr('src');
                $("#dropzone-img").show();
                $( this ).hide();
            });

            if($('#switchery').val()=='1'){
                $('#switchery').trigger('click');
            }
            $( "#switchery" ).on( "change", function() {
                if( $( this ).prop('checked') ) {
                    $( this ).attr('value', '1');
                }else{
                    $( this ).attr('value', '0');
                }
            });

            if($('#is_recomended').val()=='1'){
                $('#is_recomended').trigger('click');
            }
            $( "#is_recomended" ).on( "change", function() {
                if( $( this ).prop('checked') ) {
                    $( this ).attr('value', '1');
                }else{
                    $( this ).attr('value', '0');
                }
            });
        });
    </script>
@stop