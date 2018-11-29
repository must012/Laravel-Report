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

                @yield('form')

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
                <form action="http://www.aladin.co.kr/ttb/api/ItemSearch.aspx">
                    <div class="modal-body d-flex">
                        <input type="hidden" name="ttbkey" value="ttbtnwo941642001">
                        <input type="hidden" name="start" value="1">
                        <input type="hidden" name="MaxResults" value="10">
                        <input type="hidden" name="Cover" value="Small">
                        <input type="hidden" name="Output" value="JS">
                        <input class="form-control col-4 mr-3" type="text" name="Query" placeholder="책 제목">
                        <button type="submit" class="btn btn-sm write-btn blueBtn">검 색
                        </button>
                    </div>
                    <div class="modal-footer">
                        <button class="btn blueBtn" type="submit">선택 완료</button>
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