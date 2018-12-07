<?php

namespace App\Listeners;

//use App\Events\=artile.created;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PostsEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  =artile.created  $event
     * @return void
     */
    public function handle(\App\Events\PostsEvent $event)
    {
        if($event->action === 'created'){
            \Log::info(sprintf(
                '새로운 포스트가 등록되었습니다: %s',
                $event->post->title
            ));
        }
    }
}
