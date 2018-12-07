<li class="list-group-item p-2 " id="edit{{ $comment->id }}" style="display: none;">
    <form action="{{ route('comments.update', $comment->id) }}" method="post">
        @csrf
        {{ method_field('PUT') }}

        <div class="writer d-flex justify-content-between p-1">
            <div class="comment-writer mt-1 ml-2">{{ auth()->user()->name }}</div>
            <div class="mr-2">
                <button class="btn greBtn newComment" type="submit"><i
                            class="far fa-edit"> 수정</i>
                </button>
            </div>
        </div>

        <div class="panel-body mt-1 {{ $errors->has('content')?'has-error':'' }}">
                    <textarea class="form-control" name="content" rows="3"
                              placeholder="댓글을 작성해주세요" required>{{ old('content',$comment->content) }}</textarea>
            {!! $errors->first('content','<span class="form-error">:message</span>') !!}
        </div>

    </form>
</li>
