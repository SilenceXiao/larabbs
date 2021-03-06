<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use Notifiable{
        notify as protected laravelNotify;
    }

    use MustVerifyEmailTrait;

    protected $table ='users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar','introduction'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 访问器-头像链接字段
     * @param string $value
     * @return string
     */
    public function getAvatarAttribute($value)
    {
        if (empty($value)) {
            return '/images/header.gif';
        }
        return $value;
    }

    public function topics(){
        return $this->hasMany(Topic::class);
    }

    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    public function replies(){
        return $this->hasMany(Reply::class);
    }

    //消息通知
    // public function notify($instance){
    //     // 如果要通知的人是当前用户，就不必通知了
    //     if($this->id  == Auth::id()){
    //         return false;
    //     }

    //     //只有数据库类型的才会被通知 直接发送 Email 或者其他的都 Pass
    //     if(method_exists($instance,'toDatabase')){
    //         $this->increment('notification_count');
    //     }

    //     $this->laravelNotify($instance);
    // }

    //回复消息通知
    public function toRelyNotify($instance){

        if($this->id == Auth::id()){
            return false;
        }

        if(method_exists($instance,'toDatabase')){
            $this->increment('notification_count');
        }

        $this->laravelNotify($instance);
    }

    public function markAsRead(){
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }
}
