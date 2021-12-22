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

                    {!! Form::open(['method' => 'POST', 'route' => ['master.hardware.store']]) !!}
                        <div class="row justify-content-between">

                        <div class="col-lg-3">
                            <div class="form-group mb-2">
                                <label>Upload Foto</label>
                                <div class="dropzone-img mt-2">
                                    <a class="btn btn-danger icon-lg" id="img-remove"><i class="fe-trash"></i></a>
                                    <div id="dropzone-img">Click or drop something here</div>
                                    <input class="form-file" type="file" name="file">
                                    <img src="" id="img-preview" style="width:100%"/>
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
        
@endsection

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

        });
    </script>
@stop