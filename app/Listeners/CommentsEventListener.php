<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\CommentsEvent;

class CommentsEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    public function handle(CommentsEvent $event)
    {
        $comment = $event->comment;
        $comment->load('commentable');


    }
}
