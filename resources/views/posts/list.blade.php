@extends('layouts.master')

@section('main')

    <div class="row">
        <div class="subject col-md-10"><h2 class="d-inline-block">Board</h2></div>

        @auth
            <div class="col-2 pl-5">
                <button class="btn float-right write-btn blueBtn" onclick="location.href='/write'">
                    <i class="far fa-edit"> 글쓰기</i>
                </button>
            </div>
        @endauth
    </div>

    <hr>
    <div class="container">
        <ul class="list-group">
            @forelse($list as $value)

                <li class="list-group-item d-flex flex-row contents-list">

                    <!--                        제목 부분 div -->
                    <div class="list-title-wrapper col-md-6 pt-md-2">
                        <div class="list-tag d-flex">
                            <p class="list-group-item-text article-id mr-md-3"><?= ($page - 1) * COUNT_LIST + $value["listCount"] ?> </p>
                            <a href="#" class="list-group-item-text item-tag label label-info">태그 부분 </a>
                        </div>
                        <p class="list-title detail"
                           onclick="location.href = '/board/detail?num=<?= $value["num"] ?>'"><?= $value["title"] ?></p>

                    </div>

                    <!--                        작성자 및 날짜 div-->
                    <div class="list-data-wrapper col-md-4 pt-md-2">
                        <div class='content-data'>
                            <div class="writer-info"><p class="writer"><?= $value["nick"] ?></p>
                                <div class="published"><?= $value["publish"] ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--                        댓글 부분 div  -->

                    <div class="col-md-2 p-0 mt-2 d-flex justify-content-around">
                        <div class="d-flex p-0" id="comment-count-box"
                             onclick="location.href = '/board/detail?num=<?= $value["num"] ?>#comments'">
                            <div class="item-comment-icon p-0"><i class="far fa-comment-alt fa-sm"></i>
                            </div>
                            <div class="item-comment-count p-0 ml-2"><?= $value["countComments"] ?></div>
                        </div>

                        <div class="d-flex p-0" id="recommend-count-box">
                            <div class="item-comment-icon p-0"><i class="far fa-thumbs-up fa-sm"></i>
                            </div>
                            <div class="item-comment-count p-0 ml-2"><?= $value["countComments"] ?></div>
                        </div>
                    </div>

                </li>

            @empty
                <li class="list-group-item d-flex flex-row contents-list">

                    <div class="col-12"> no have post!</div>

                </li>
            @endforelse
        </ul>
    </div>

    <nav aria-label="pagination" class="pt-1">
        <ul class="pagination justify-content-center mb-0">

            <!--   첫 페이지 이동   -->

            <?php if ($page != 1) : ?>
            <li class="page-item">
                <a class="page-link" href="/board?page=1">처음</a>
            </li>
            <?php endif; ?>

        <!--   전 페이지 이동   -->

            <?php if ($startPage == 0) : ?>
            <li class="page-item disabled"><span class="page-link">&laquo;</span>
            <?php else : ?>
            <li class="page-item"><a class="page-link"
                                     href="/board?page=<?= ($startPage > 0) ? $startPage : 1 ?>">&laquo;</a>
                <?php endif; ?></li>

            <!-- 숫자 생성 -->

            <?php for ($i = $startPage; $i < $endPage; $i++) : ?>
            <?php if ($page == ($i + 1)) :
                echo '<li class="page-item active">';
            else :
                echo '<li class="page-item">';
            endif; ?><a class="page-link" href="/board?page=<?= $i + 1 ?>"><?= $i + 1 ?></a>
            </li>
            <?php endfor; ?>

        <!--   다음 페이지 이동   -->

            <?php if ($endPage < $totalPage) : ?>
            <li class="page-item"><a class="page-link" href="/board?page=<?= $endPage + 1 ?>">&raquo;</a>

            </li>
            <?php else : ?>
            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
            <?php endif; ?>

        <!--   끝 페이지 이동   -->

            <?php if ($page != $totalPage) : ?>
            <li class="page-item">
                <a class="page-link"
                   href="/board?page=<?= floor(($totalPage / COUNT_PAGE)) * 10 + ($totalPage % COUNT_PAGE) ?>">끝</a>
            </li>
            <?php endif; ?>

        </ul>
    </nav>
@endsection

@section('script')
    <script>
        var $link;
        var $main;

        $('.side-nav').click(function () {
            $('.side-nav').removeClass('hover');
            $(this).addClass('hover');
        });

        $('.nav-item a').click(function (e) {
            // e.preventDefault();
            $link = $(this).attr('href');
            $main.attr()
        });
    </script>
@endsection