<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;
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
        // if(!$topic->slug) {
        //     // 推送任务到队列
        //     dispatch(new TranslateSlug($topic));
        //     //$topic->slug = app(SlugTranslateHandler::class)->translateNew($topic->title);
        // }

    }

    public function saved(Topic $topic){
        //isDirty() 判断属性是否修改
        if(!$topic->slug || $topic->isDirty('title')) {
            // 推送任务到队列
            dispatch(new TranslateSlug($topic));
        }
    }
}