@extends('layouts.master')

@section('header')
<script type="text/javascript" src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('main')
<div class="row">
    <div class="subject col-md-10 col-sm-8 pt-sm-3"><h2>Detail</h2></div>

    <div class="col-2 pl-5 pt-sm-3">
        <button class="btn greBtn" onclick="location.href= '{{ route('posts.index') }}'"><i class="fas fa-list"> 목록</i></button>
    </div>

</div>

<hr>

<div class="panel panel-default">

    <div class="panel-heading d-flex pt-2 pb-2">
        <div class="contents-title col-md-3 col-sm-5">
            <div class="contents-writer" title="작성자">{{  }}</div>
            <div class="contents-data" title="작성일"><?= $data["publish"] ?></div>
        </div>
        <div class="col-md-4 col-lg-4 col-sm-1 empty-flex-box"></div>
        <!--        <div class="view-data pt-3 pr-5 col-2 d-flex flex-row-reverse">-->
        <!--            &nbsp;--><?//= $count ?><!--<i class="pt-1 far fa-eye" title="조회수"></i>-->
        <!--        </div>-->

        <div class="col-md-2 p-0 mt-2 d-flex justify-content-around">
            <div class="d-flex p-0" id="comment-count-box" onclick="location.href = '/board/detail?num=<?= $value["num"] ?>#comments'">
                <div class="item-comment-icon p-0"><i class="far fa-comment-alt fa-sm"></i>
                </div>
                <div class="item-comment-count p-0 ml-2"><?= $count ?></div>
            </div>

            <div class="d-flex p-0" id="recommend-count-box">
                <div class="item-comment-icon p-0"><i class="far fa-thumbs-up fa-sm"></i>
                </div>
                <div class="item-comment-count p-0 ml-2"><?= $count ?></div>
            </div>
        </div>

        <?php if ($id == $data["writer"]): ?>
        <div class="action col-md-3 col-lg-3 pl-4 pt-2 d-flex flex-row-reverse">
            <button class="btn blueBtn" onclick="location.href= '/board/modify/<?= $num ?>'"><i
                        class="far fa-edit">수정</i>
            </button>
            <button class="btn mr-md-1 mr-lg-2 redBtn" onclick="checkDeleteContents(<?= $data["num"] ?>)"><i
                        class="far fa-trash-alt">
                    삭제</i>
            </button>
        </div>
        <?php endif; ?>

    </div>

    <div class="panel-body contents-panel-body pb-4">
        <div class="col-12 pt-2"><h3><?= $data["title"] ?></h3>
            <hr style="background-color: whitesmoke">
            <div><?= $data["contents"] ?></div>
        </div>
    </div>

    <ul class="list-group file-download">
        <li class="list-group-item file-scroll text-center">첨부 <?= count($files) ?><?php if (count($files) > 0): ?> <i
                    class="angle-check fas fa-angle-down"></i> <? endif; ?></li>
        <?php foreach ($files as $file): ?>
        <li class="list-group-item file" style="display: none;" onclick="location.href='/file/download?id=<?= $file["fileId"] ?>'"><?= $file["originName"] ?></li>
        <?php endforeach; ?>
    </ul>

</div>

<!-- 댓글 부분 -->
<div class="panel panel-default mt-4 mb-sm-3" id="comments">
    <!-- 댓글 갯수 -->
    <ul class="list-group">
        <li class="list-group-item comment-count border-0">댓글 <?= count($comments) ?></li>
        <!-- 댓글 내용 -->
        <?php foreach ($comments as $comment): ?>

        <li class="list-group-item comments <?php if(!$comment["rootWriter"]){echo "root-comment";}else {echo "tree-comment";} ?> " id="<?= $comment["num"] ?>">

            <div class="comment-head d-flex mb-2">
                <div class="comment-data d-flex pl-0 col-md-9 col-sm-8">
                    <?php if (isset($comment["rootWriter"])): ?>
                    <div class="col-2 pr-0"><?= $comment["writerNick"] ?> //</div>
                    <?php endif ?>
                    <div class="writer pl-0 mr-3 col-5">
                        <?= $comment["writerNick"] ?></div>
                    <div class="comment-created d-flex col-md-5 col-sm-7 flex-row-reverse"><?= $comment["createDate"] ?></div>
                </div>

                <?php if ($id): ?>
                <div class="comment-action col-md-3 col-sm-2 p-sm-0 d-flex flex-row-reverse">
                    <div class="reply">

                        <button class="btn yellowBtn replyMessages"
                                id="btn-<?= $comment["num"] ?>" title="대댓글작성">
                            <i class="fas fa-reply fa-sm"></i>
                        </button>
                        <?php if ($id == $comment["writer"]): ?>
                        <button class="btn redBtn"
                                onclick="checkDeleteComment(<?= $comment["num"] ?>, '<?= $comment["writer"] ?>')"
                                title="댓글삭제">
                            <i class="far fa-trash-alt fa-sm"></i>
                        </button>
                        <button class="btn blueBtn" id="comment-rewrite" style="width: 38px;" title="수정하기"><i
                                    class="fas fa-edit fa-sm"></i>
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>

            <?php if (isset($comment["rootWriter"])): ?>
            <div class="comment-content pl-3"><?= $comment["comment"] ?></div>
            <?php else: ?>
            <div class="comment-content"><?= $comment["comment"] ?></div>
            <?php endif; ?>


        </li>

        <!-- 대댓글 작성 -->
        <li class="list-group-item p-1 comment-reply-<?= $comment["num"] ?>" style="display: none">
            <form action="/comment/update" method="post">

                <input type="hidden" name="conNum" value="<?= $num ?>">
                <input type="hidden" name="rootComment" value="<?= $comment["rootComment"] ?? $comment["num"]; ?>">
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
        <?php endforeach; ?>

        <?php if ($id): ?>
        <li class="list-group-item p-1">
            <form action="/comment/update" method="post">

                <input type="hidden" name="conNum" value="<?= $num ?>">

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
                              placeholder="댓글을 작성해주세요" required></textarea>
                </div>

            </form>
        </li>
        <?php endif; ?>
    </ul>
</div>
@endsection

@section('script')
<script>

    function checkDeleteContents(num) {

        var con = confirm("삭제 하시겠습니까?");
        if (con) {
            location.href = "/board/delete/" + num;
        } else
            return;
    }

    function checkDeleteComment(num, writer) {
        var con = confirm("삭제 하시겠습니까?");

        if ("<?= $id ?>" == writer) {
            if (con) {
                location.href = "/comment/delete/" + num;
            } else
                return;
        }
        else {
            alert("본인이 작성한 댓글만 삭제할 수 있습니다.");
            location.reload();
        }
    }

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