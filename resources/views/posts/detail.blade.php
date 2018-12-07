@extends('layouts.master')

@section('main')
    <div class="row">
        <div class="subject col-md-10 col-sm-8 pt-sm-3"><h2>Detail</h2></div>

        <div class="col-2 pl-5 pt-sm-3">
            <button class="btn greBtn" onclick="location.href= '{{ route('posts.index') }}'"><i class="fas fa-list">
                    목록</i></button>
        </div>

    </div>

    <hr>

    <div class="panel panel-default">

        <div class="panel-heading d-flex pt-2 pb-2">
            <div class="contents-title col-md-3 col-sm-5">
                <div class="contents-writer" title="작성자">{{ $post->name }}</div>
                <div class="contents-data" title="작성일">{{ $post->created_at }}</div>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-1 empty-flex-box"></div>


            <div class="col-md-2 col-lg-3 p-0 mt-2 d-flex justify-content-around">
                <div class="d-flex p-0" id="view-count-box" title="조회수">
                    <div class="item-comment-icon p-0"><i class="far fa-eye fa-sm"></i>
                    </div>
                    <div class="item-comment-count p-0 ml-2">{{ $post->viewers()->where('post_id','=',$post->id)->count() }}</div>
                </div>


                <div class="d-flex p-0" id="comment-count-box" onclick="location.href = '#comments'" title="댓글수">
                    <div class="item-comment-icon p-0"><i class="far fa-comment-alt fa-sm"></i>
                    </div>
                    <div class="item-comment-count p-0 ml-2">{{ $post->comments()->count() }}</div>
                </div>

                <div class="d-flex p-0" id="recommend-count-box" title="추천수">
                    <div class="item-comment-icon p-0"><i class="far fa-thumbs-up fa-sm"></i>
                    </div>
                    <div class="item-comment-count p-0 ml-2">{{ $post->comments()->count() }}</div>
                </div>
            </div>
            <div class="action col-md-3 col-lg-3 pl-4 pt-2 d-flex flex-row-reverse">
                @can('update',$post)

                    <button class="btn blueBtn" onclick="location.href= '{{ route('posts.edit', $post->id) }}'"><i
                                class="far fa-edit">수정</i>
                    </button>
                @endcan

                @can('delete',$post)
                    <button class="btn mr-md-1 mr-lg-2 redBtn"
                            onclick="document.getElementById('postDelete').submit();"><i
                                class="far fa-trash-alt">
                            삭제</i>
                    </button>
                    <form action="{{ route('posts.destroy',$post->id) }}" method="POST" id="postDelete">
                        @csrf
                        {{ method_field('DELETE') }}
                    </form>

                @endcan
            </div>

        </div>

        <div class="panel-body contents-panel-body pb-4">
            <div class="col-12 pt-2"><h3>{{ $post->title }}</h3>
                <hr style="background-color: whitesmoke">
                <div class="contents">{!! $post->content !!}</div>
            </div>
        </div>

        @include('posts.AttachmentsPartial.partial',['attachments'=>$post->attachments])


    </div>

    <!-- 댓글 부분 -->
    <div class="panel panel-default mt-4 mb-sm-3" id="comments-head">
        @include('posts.comments.index')
    </div>
@endsection

@section('script')
    <script>

        $(".file-scroll").click(function (e) {
            const $fileTarget = $(".file");
            const $angleTarget = $(".angle-check");

            $fileTarget.slideToggle(200);

            $angleTarget.toggleClass("fa-angle-up");
            $angleTarget.toggleClass("fa-angle-down");
        });

    </script>

@endsection