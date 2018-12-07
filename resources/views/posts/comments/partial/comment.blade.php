@if($isTrashed and ! $hasChild)
@elseif($isTrashed and $hasChild)
    <li class="list-group-item comments  {{ $isReply?'pl-4':'pl-2' }}" id="{{ $comment->id }}">

        <div class="comment-head mb-2">
            <div class="media comment-body p-0 col-12 d-flex justify-content-between" data-id="{{ $comment->id }}"
                 id="comment_{{ $comment->id }}">
                <div class="d-flex col-4">
                    <div class="writer p-0 mr-2 col-6">
                        {{ $comment->user->name }}
                    </div>
                    <div class="comment_date col-6 p-0">
                        <small>
                            {{ $comment->created_at->diffForHumans() }}
                        </small>
                    </div>
                </div>
                <div class="comment-action col-5 col-sm-6 d-flex flex-row-reverse">
                    @can('comment_update',$comment)
                        <button class="btn redBtn delete-comment"
                                title="댓글삭제">
                            <i class="far fa-trash-alt fa-sm"></i>
                        </button>
                        <button class="btn blueBtn edit-comment" style="width: 38px;"
                                title="수정하기" id="{{ $comment->id }}"><i
                                    class="fas fa-edit fa-sm"></i>
                        </button>
                    @endcan
                    @if($currentUser)
                        <button class="btn yellowBtn reply-comment"
                                title="대댓글작성" id="{{ $comment->id }}">
                            <i class="fas fa-reply fa-sm"></i>
                        </button>
                    @endif
                </div>

            </div>

            <div class="content-comment">
                삭제된 덧글 입니다
            </div>

        @if($currentUser)
            @include('posts.comments.partial.create',['parentId' => $comment->id ])
        @endif

        @can('comment_update',$comment)
            @include('posts.comments.partial.edit')
        @endcan

        @forelse ($comment->replies as $reply)
            @include('posts.comments.partial.comment',[
            'comment'=> $reply,
            'isReply'=> true,
            'hasChild' => $reply->replies->count(),
            'isTrashed' => $reply->trashed(),
            ])

            @empty
        @endforelse

    </li>
@else
    <li class="list-group-item comments  {{ $isReply?'pl-4':'pl-2' }}" id="{{ $comment->id }}">

        <div class="comment-head mb-2" id="comment_{{ $comment->id }}">
            <div class="media comment-body p-0 col-12 d-flex justify-content-between" data-id="{{ $comment->id }}">
                <div class="d-flex col-4">
                    <div class="writer p-0 mr-2 col-6">
                        {{ $comment->user->name }}
                    </div>
                    <div>
                        child = {{ $hasChild }}
                    </div>
                    <div class="comment_date col-6 p-0">
                        <small>
                            {{ $comment->created_at->diffForHumans() }}
                        </small>
                    </div>
                </div>
                    <div class="comment-action col-5 col-sm-6 d-flex flex-row-reverse">
                        @can('comment_update',$comment)
                            <button class="btn redBtn delete-comment"
                                    title="댓글삭제">
                                <i class="far fa-trash-alt fa-sm"></i>
                            </button>
                            <button class="btn blueBtn edit-comment" style="width: 38px;"
                                    title="수정하기" id="{{ $comment->id }}"><i
                                        class="fas fa-edit fa-sm"></i>
                            </button>
                        @endcan
                        @if($currentUser)
                            <button class="btn yellowBtn reply-comment"
                                    title="대댓글작성" id="{{ $comment->id }}">
                                <i class="fas fa-reply fa-sm"></i>
                            </button>
                        @endif
                    </div>

            </div>
            <div class="content-comment">
                {!! $comment->content !!}
            </div>




        @if($currentUser)
            @include('posts.comments.partial.create',['parentId' => $comment->id ])
        @endif

        @can('comment_update',$comment)
            @include('posts.comments.partial.edit')
        @endcan

        @forelse ($comment->replies as $reply)
            @include('posts.comments.partial.comment',[
            'comment'=>$reply,
            'isReply'=>true,
            'hasChild' => $reply->replies->count(),
            'isTrashed' => $reply->trashed(),
            ])
        @empty
        @endforelse

    </li>
@endif
