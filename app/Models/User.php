<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
Use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContracts;
use Auth;

class User extends Authenticatable implements MustVerifyEmailContracts
{
    use MustVerifyEmailTrait;

    use Notifiable {
        notify as protected laravelNotify;
    }

    public function notify($instance)
    {
        //如果通知的人是当前用户，就不必通知了
        if ($this->id == Auth::id()){
            return;
        }

        //只有数据库类型通知才需提醒，直接 发送email和其他的 都pass
        if (method_exists($instance, 'toDatabase')){
            $this->increment('notification_count');
        }

        $this->laravelNotify($instance);
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'introduction', 'avatar',
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

    public function topics()
    {
        //一个用户可以拥有多个话题
        return   $this->hasMany(Topic::class);
    }

    public function replies()
    {
        //一个用户可以有多个回复
        return $this->hasMany(Reply::class);
    }

    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }


    public function markAsRead()
    {
        $this->notification_count =  0;
        $this->save();
        $this->unreadNotifications->markAsRead();
        
    }

}
