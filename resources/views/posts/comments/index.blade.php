<ul class="list-group">
    <li class="list-group-item comment-count border-0">댓글 {{ sizeof($comments) }}</li>
    @auth
        @include('posts.comments.partial.create')
    @else
        @include('posts.comments.partial.login')
    @endauth

    @forelse($comments as $comment)
        @include('posts.comments.partial.comment',[
        'parentId' => $comment->id,
        'isReply' => false,
        'hasChild' => $comment->replies->count(),
        'isTrashed' => $comment->trashed()
        ])

    @empty
    @endforelse
</ul>

@section('script')
    @parent
    <script>
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

        $('.delete-comment').on('click', function (e) {
            var commentId = $(this).closest('.comment-body').data('id');

            if (confirm("댓글을 삭제 하시겠습니까?")) {
                $.ajax({
                    type: 'POST',
                    url: "/comments/" + commentId,
                    data: {

                        _method: "DELETE"
                    },
                    success: function () {
                        $('#comment_' + commentId + ' .content-comment').addClass('text-info').fadeIn(1000, function () {
                            $(this).text('삭제된 댓글 입니다');
                        });
                        // $('#comment_' + commentId).fadeOut(1000, function () {
                        //     $(this).remove()
                        // });
                    },
                    error: function () {
                        alert('error!');
                    }
                })
            }
        });

        var $replyTarget = $(".reply-comment");

        $replyTarget.click(function (e) {
            var $id = $(this).attr('id');
            var $item = $("li[id=re" + $id + "]");
            $item.slideToggle(200);
        });

        var $editTarget = $(".edit-comment");

        $editTarget.click(function (e) {
            var $id = $(this).attr('id');
            var $item = $("li[id=edit" + $id + "]");
            $item.slideToggle(200);
        });
    </script>

@endsection