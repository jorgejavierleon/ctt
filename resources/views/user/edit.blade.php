@extends('layouts.app')
@section('css')
    <link  href="/css/cropper.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Datos</div>

                    <div class="panel-body">
                        {!! Form::model($user, ['route' => ['user.update', $user], 'method' => 'PUT']) !!}
                            @include('user.partials.form')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Avatar</div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div>
                                    <img id="avatar" src="{{$user->avatar}}" style="max-width: 100%">
                                </div>
                            </div>
                            <div class="col-md-4 col-md-offset-2">
                                <div class="img-preview" style="overflow: hidden; height: 130px; width: 200px;"></div>
                                <div class="btn-group" role="group" style="padding-top: 2em">
                                    <label title="Upload image file" for="inputImage" class="btn btn-default">
                                        <input type="file" accept="image/*" name="file" id="inputImage" class="hide">
                                        <i class="fa fa-download"></i> Cargar
                                    </label>
                                    <button id="save-image" type="button" class="btn btn-default">
                                        <i class="fa fa-crop"></i> Guardar
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-offset-1">
                {!! Form::open(['route' => ['user.destroy', $user->id], 'method' => 'delete']) !!}
                {!! Form::submit('Eliminar cuenta', ['class' => 'btn btn-default']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection

@section('js')
    @parent
    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\UpdateUserRequest') !!}
    <script src="/js/cropper.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#avatar').cropper({
                preview: ".img-preview",
                minContainerWidth: 589,
                minContainerHeight: 394,
            });

            var $inputImage = $("#inputImage");
            if (window.FileReader) {
                $inputImage.change(function() {
                    var fileReader = new FileReader(),
                    files = this.files,
                    file;

                    if (!files.length) {
                        return;
                    }

                    file = files[0];

                    if (/^image\/\w+$/.test(file.type)) {
                        fileReader.readAsDataURL(file);
                        fileReader.onload = function () {
//                            $inputImage.val("");
                            $('#avatar').cropper("reset", true).cropper("replace", this.result);
                        };
                    } else {
                        showMessage("Please choose an image file.");
                    }
                });
            } else {
                $inputImage.addClass("hide");
            }

            $("#save-image").click(function(){
                $('#avatar').cropper('getCroppedCanvas').toBlob(function (blob) {
                    var formData = new FormData();

                    formData.append('croppedImage', blob);
                    formData.append('_token', "{{ csrf_token() }}");

                    $.ajax('/user/avatar', {
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function () {
                            location.reload();
                        },
                        error: function () {
                            console.log('Upload error');
                        }
                    });
                });
            });


        });
    </script>
@endsection