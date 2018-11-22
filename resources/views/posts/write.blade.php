@extends('layouts.master')

@section('header')

    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>

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
            <form class="mb-md-5 mb-sm-4" action="{{ route('posts.store') }}" enctype="multipart/form-data"
                  method="post">
                @csrf
                <input type="hidden" name="writer" value="{{ Auth::user()->email }}" readonly>
                <input type="hidden" name="name" value="{{ Auth::user()->name }}" readonly>

                <div class="panel-heading d-flex justify-content-between pt-2 pb-2">

                    <div class="contents-title col-3 pt-2">
                        <div class="contents-writer">작성자 : {{ Auth::user()->name }} </div>
                    </div>
                    <div class="action col-2 pt-md-1">
                        <button class="btn ml-3 greBtn" id="submit-all" type="submit"><i
                                    class="far fa-edit"> 저장</i>
                        </button>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="col-12 p-3 pb-1 m-0 form-group d-flex">
                        <input class="form-control col-4 mr-3" type="text" name="book" placeholder="책 제목">
                        <button class="btn btn-sm write-btn blueBtn" data-toggle="modal" data-target="#bookSearch">검 색</button>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="col-12 pt-2 form-group {{ $errors->has('title')?'has-error':'' }}">

                        <input type="text" id="title" class="form-control" name="title" aria-label="제목" placeholder="제목"
                               value="{{ old('title') }}"
                               required>
                        {!! $errors->first('title','<span class="form-error">:message</span>') !!}
                        <hr style="background-color: whitesmoke">
                        <div class="form-group">
                            <textarea class="form-control" id="contents" name="contents"
                                      required> {{ old('contents') }}</textarea>

                        </div>
                    </div>
                </div>

                <div class="panel-footer col-11 m-auto dropzone">
                    <div id="upfile-box" class="col-12 input-group p-0">
                        <div class="input-group-append file-text pt-2 pl-1 pr-1">
                            <span class="input-group-text">업로드</span>
                        </div>
                        <div class="col-11 p-0">
                            <input type="file" class="btn col-12 custom-file-input border border-primary" id="upFile"
                                   name="upFiles[]" multiple>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    @endguest

@endsection

@section('modal')

    <div class="modal fade" id="bookSearch" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div></div>
                    <div class="modal-title">책 검색</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="modal-out" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-signup" action="http://www.aladin.co.kr/ttb/api/ItemSearch.aspx?ttbkey=ttbtnwo941642001&start=1&MaxResults=10&Cover=Small&Output=JS">
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button class="btn blueBtn" type="submit">변경완료</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        CKEDITOR.replace('contents', {
            filebrowserUploadUrl: "/posts/imgUpload",
            extraPlugins: 'uploadimage',
            height: 400
        });
    </script>
@endsection