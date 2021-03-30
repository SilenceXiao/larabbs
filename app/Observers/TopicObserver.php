<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }

    //保存事件
    public function saving(Topic $topic){
        //XXS过滤
        $topic->body = clean(htmlspecialchars_decode($topic->body), 'user_topic_body');
        
        $topic->excerpt = make_excerpt($topic->body);
        if(!$topic->slug) {
           $topic->slug = app(SlugTranslateHandler::class)->translateNew($topic->title);
        }

    }
}