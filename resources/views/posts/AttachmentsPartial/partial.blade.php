<ul class="list-group file-download">
    <li class="list-group-item file-scroll text-center">첨부 {{ $attachments->count() }}
        @if($attachments->count())
            <i class="angle-check fas fa-angle-down"></i>
    </li>
     @foreach($attachments as $attachment)
         <li class="list-group-item file" style="display: none;" onclick="location.href='{{ route('attachments.show', $attachment) }}'">{{ $attachment->origin_name }}</li>
     @endforeach
    @endif
</ul>