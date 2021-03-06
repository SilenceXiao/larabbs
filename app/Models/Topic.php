<?php

namespace App\Models;
use App\Models\User;
use App\Models\Category;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'category_id', 'excerpt', 'slug'];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }


    //一个话题多个回复
    public function replies(){
        return $this->hasMany(Reply::class);
    }

    public function scopeWithOrder($query,$order)
    {
        switch ($order) {
            case 'recent':
                $query->Recent();
                break;
            
            default:
                $query->RecentReplied();
                break;
        }

        return $query->with('user','category');
    }

    //最新发布
    public function scopeRecent($query){
        return $query->orderBy('created_at','desc');
    }

    //最新回复
    public function scopeRecentReplied($query){
        // 当话题有新回复时，我们将编写逻辑来更新话题模型的 reply_count 属性，
        // 此时会自动触发框架对数据模型 updated_at 时间戳的更新
        return $query->orderBy('updated_at','desc');
    }

    public function link($params = [])
    {
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }
}

