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
                    <button class="btn mr-md-1 mr-lg-2 redBtn" onclick="document.getElementById('postDelete').submit();"><i
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
    <div class="panel panel-default mt-4 mb-sm-3" id="comments">
        <!-- 댓글 갯수 -->
        <ul class="list-group">
            <li class="list-group-item comment-count border-0">댓글 {{ $post->comments()->count() }}</li>
            <!-- 댓글 내용 -->
            @forelse($post->comments()->get() as $comment)

                <li class="list-group-item comments @if(!$comment->root_writer_name) root-comment @else tree-comment @endif"
                    id="{{ $comment->id }}">

                    <div class="comment-head d-flex mb-2">
                        <div class="comment-data d-flex pl-0 col-md-9 col-sm-8">
                            <?php if (isset($comment["rootWriter"])): ?>
                            <div class="col-2 pr-0"><?= $comment["writerNick"] ?> //</div>
                            <?php endif ?>
                            <div class="writer pl-0 mr-3 col-5">
                                <?= $comment["writerNick"] ?></div>
                            <div class="comment-created d-flex col-md-5 col-sm-7 flex-row-reverse"><?= $comment["createDate"] ?></div>
                        </div>

                        @auth
                            <div class="comment-action col-md-3 col-sm-2 p-sm-0 d-flex flex-row-reverse">
                                <div class="reply">

                                    <button class="btn yellowBtn replyMessages"
                                            id="btn-<?= $comment["num"] ?>" title="대댓글작성">
                                        <i class="fas fa-reply fa-sm"></i>
                                    </button>
                                    @if(Auth::user()->name == $comment->name)
                                        <button class="btn redBtn"
                                                onclick="checkDeleteComment( {{ $comment->id }}, '{{ $comment->writer }}')"
                                                title="댓글삭제">
                                            <i class="far fa-trash-alt fa-sm"></i>
                                        </button>
                                        <button class="btn blueBtn" id="comment-rewrite" style="width: 38px;"
                                                title="수정하기"><i
                                                    class="fas fa-edit fa-sm"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        @endauth

                    </div>

                    <?php if (isset($comment["rootWriter"])): ?>
                    <div class="comment-content pl-3"><?= $comment["comment"] ?></div>
                    <?php else: ?>
                    <div class="comment-content"><?= $comment["comment"] ?></div>
                    <?php endif; ?>


                </li>

                <!-- 대댓글 작성 -->
                <li class="list-group-item p-1 comment-reply-{{ $comment->id }}" style="display: none">
                    <form action="/comment/update" method="post">

                        <input type="hidden" name="conNum" value="{{ $post->id }}">
                        <input type="hidden" name="rootComment"
                               value="<?= $comment["rootComment"] ?? $comment["num"]; ?>">
                        <input type="hidden" name="parentComment" value="<?= $comment["num"] ?>">
                        <input type="hidden" name="rootWriter" value="<?= $comment["writer"] ?>">

                        <div class="writer d-flex justify-content-between p-1">
                            <div class="comment-writer mt-1 ml-2"><?= $name ?></div>
                            <div class="mr-2">
                                <button class="btn greBtn newComment" type="submit" data-connum="<?= $num ?>"><i
                                            class="far fa-edit"> 등록</i>
                                </button>
                            </div>
                        </div>

                        <div class="panel-body mt-1">
                    <textarea class="form-control" name="comment" id="comment<?= $num ?>" rows="3"
                              placeholder="댓글을 작성해주세요!" required></textarea>
                        </div>

                    </form>
                </li>
            @empty
            @endforelse

            @auth
                <li class="list-group-item p-1">
                    <form action="/comment/update" method="post">

                        <input type="hidden" name="conNum" value="{{ $post->id }}">

                        <div class="writer d-flex justify-content-between p-1">
                            <div class="comment-writer mt-1 ml-2"><?= Auth::user()->name ?></div>
                            <div class="mr-2">
                                <button class="btn greBtn newComment" type="submit" data-connum="{{ $post->id }}"><i
                                            class="far fa-edit"> 등록</i>
                                </button>
                            </div>
                        </div>

                        <div class="panel-body mt-1">
                    <textarea class="form-control" name="comment" id="comment{{ $post->id }}" rows="3"
                              placeholder="댓글을 작성해주세요" required></textarea>
                        </div>

                    </form>
                </li>
            @endauth
        </ul>
    </div>
@endsection

@section('script')
    <script>

        // language=JQuery-CSS

        $(".replyMessages").click(function (e) {
            var num = $(this).attr("id");
            num = num.split('-').pop();
            const $target = $(".comment-reply-" + num);

            $target.slideToggle(200);
        });

        $(".file-scroll").click(function (e) {
            const $fileTarget = $(".file");
            const $angleTarget = $(".angle-check");

            $fileTarget.slideToggle(200);

            $angleTarget.toggleClass("fa-angle-up");
            $angleTarget.toggleClass("fa-angle-down");
        });


    </script>

@endsection