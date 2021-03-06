@extends('layouts.master')

@section('header')

    {{-- ckeditor.js --}}
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>

    {{-- Dropzone css --}}
    <link rel="stylesheet" href="{{ asset('css/dropzone.css') }}">

    {{-- Dropzone js --}}
    <script src="{{ asset('js/dropzone.js') }}"></script>

@endsection

@if(Session::has('message'))
    <div class="alert alert-info">
        {{ Session::get('message') }}
    </div>
@endif

@section('main')

    @guest
        <script>
            alert("로그인 한 사용자만 글 쓰기가 가능합니다");
            history.back();
        </script>
    @else
        <div class="row">
            <div class="subject col-md-8"><h2 class="d-inline-block">Write</h2></div>

            <div class="col-4 pl-5">

                <button class="btn float-right write-btn blueBtn" onclick="location.href='{{ route('posts.index') }}'">
                    <i class="fas fa-list"> 목록</i>
                </button>

            </div>
        </div>

        <hr style="background-color: whitesmoke">

        <div class="panel-default">

            @yield('form')

        </div>

    @endguest

@endsection

{{--@include('posts.modal')--}}

@section('script')
    <script>
        CKEDITOR.replace('contents', {
            filebrowserUploadUrl: "/posts/imgUpload?type=image",
            extraPlugins: 'uploadimage',
            height: 400
        });

        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

        var form = $('#store'),
            dropzone = $('div.dropzone'),
            dzControl = $('label[for=my-dropzone]>small');

        Dropzone.autoDiscover = false;

        var myDropzone = new Dropzone('div#my-dropzone', {
            url: '/attachments',
            addRemoveLinks: true,
            paramName: 'upFiles',
            maxFilesize: 10,
            acceptedFiles: '.jpg,.png,.zip,.tar',
            uploadMultiple: true,
            params: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                post_id: '{{ $list->id }}'
            },
            dictDefaultMessage: '<div class="text-center text-muted">' + '<h2>Drag & Drop ! </h2>' + '<p>or Click!</p></div>',
            dictInvalidFileType: 'jpg,png,zip,tar 파일만 업로드 가능'
        });

        myDropzone.on('successmultiple', function (file, data) {

            for (var i = 0, len = data.length; i < len; i++) {
                handleFormElement(data[i].id);

                file[i]._id = data[i].id;
                file[i]._name = data[i].name;
                file[i]._size = data[i].size;
            }
        });

        myDropzone.on('removedfile', function (file) {
            alert(file._id);
            $.ajax({
                type: 'DELETE',
                url: '/attachments/' + file._id,
                success: function (data) {
                    handleFormElement(data.id, true);
                },
                error: function (e) {
                    alert('error!');
                }
            })
        });

        var handleFormElement = function (id, remove) {

            if (remove) {
                $('input[name="upFiles[]"][value="' + id + '"]').remove();
                return;
            }

            $('<input>', {
                type: 'hidden',
                name: 'upFiles[]',
                value: id
            }).appendTo(form);
        };

        var handleContent = function (objId, imgUrl, remove) {
            var caretPos = document.getElementById(objId).selectionStart;
            var content = $('#' + objId).val();
            var imgMarkdown = '![](' + imgUrl + ')';

            if (remove) {
                $('#' + objId).val(
                    content.replace(imgMarkdown, '')
                );

                return;
            }
            $('#' + objId).val(
                content.substring(0, caretPos) + imgMarkdown + '\n' + content.substring(caretPos)
            );
        };

        dzControl.on('click', function (e) {
            dropzone.fadeToggle(500);
            dzControl.fadeToggle(0);
        });
    </script>
@endsection