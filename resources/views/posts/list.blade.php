@extends('layouts.master')

@section('main')

    <div class="row">

        <div class="subject col-md-6"><h2 class="d-inline-block">독후감</h2></div>

        <div class="col-6 pl-5 d-flex flex-row-reverse">
            @auth
                <button class="btn float-right write-btn blueBtn mr-3 ml-2" onclick="location.href='/posts/create'">
                    <i class="far fa-edit"> 글쓰기</i>
                </button>
            @endauth
            <button class="btn greBtn dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-sort"></i> 정렬
            </button>
            <ul class="dropdown-menu p-0" role="menu">
                @foreach(config('project.sorting') as $column => $text)
                    <li class = "list-group-item">
                        {!! link_for_sort($column,$text) !!}
                    </li>
                @endforeach
            </ul>

        </div>


    </div>

    <hr>

    <div class="container">
        <ul class="list-group">
            @forelse($list as $value)

                <li class="list-group-item d-flex flex-row contents-list">
                    <div class="post-id col-1 pr-0 pt-3 pl-0">{{ $value->id }}.</div>
                    <!--                        제목 부분 div -->
                    <div class="list-title-wrapper col-md-6 pt-md-3 pl-0">
                        <p class="list-title detail"
                           onclick="location.href = '{{ route('posts.show', $value->id) }}'">{{ $value->title }}</p>
                    </div>

                    <!--                        작성자 및 날짜 div-->
                    <div class="list-data-wrapper col-md-3 pt-md-2">
                        <div class='content-data'>
                            <div class="writer-info"><p class="writer">{{ $value->name }}</p>
                                <div class="published"> {{ $value->created_at }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--                        댓글 부분 div  -->


                    <div class="col-md-2 p-0 mt-2 d-flex justify-content-around">
                        <div class="d-flex p-0" id="comment-count-box"
                             onclick="location.href = '{{ route('posts.show', $value->id) }}#comments-head'">
                            <div class="item-comment-icon p-0" title="댓글 보기"><i
                                        class="far fa-comment-alt fa-sm"></i>
                            </div>
                            <div class="item-comment-count p-0 ml-2">{{ $value->comment_count }}</div>
                        </div>

                        <div class="d-flex p-0" id="recommend-count-box">
                            <div class="item-comment-icon p-0"><i class="far fa-thumbs-up fa-sm"></i>
                            </div>
                            <div class="item-comment-count p-0 ml-2">{{ $value->like_count }}</div>
                        </div>
                    </div>

                </li>

            @empty
                <li class="list-group-item d-flex flex-row contents-list">

                    <div class="col-12"> no have post!</div>

                </li>
            @endforelse
        </ul>
        @if($list)
            <nav aria-label="pagination" class="pt-1">
                <ul class="pagination justify-content-center mb-0">
                    @if($list->currentPage() != 1)
                        <li class="page-item">
                            <a class="page-link" href="{{route('posts.index')}}">처음</a>
                        </li>
                    @endif

                    {!! $list->render() !!}

                    @if($list->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ route('posts.index',['page'=>$list->lastPage()]) }}">끝</a>
                        </li>
                    @endif
                </ul>
            </nav>
        @endif

    </div>


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