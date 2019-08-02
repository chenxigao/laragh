<?php

namespace App\Models;


class Topic extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug'];

    public function category()
    {
        //一个话题只能属于 一个分类
        return $this->belongsTo(Category::class);
    }


    public function user()
    {
        //一个话题拥有一个作者
        return $this->belongsTo(User::class);
    }

}
