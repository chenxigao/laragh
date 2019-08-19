<?php

namespace App\Models;


class Topic extends Model
{
    protected $fillable = ['title', 'body', 'category_id','excerpt', 'slug'];

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


    public function scopeWithOrder($query, $order)
    {
        //不同的排序 使用不同的读取逻辑
        switch ($order){
            case 'recent':
                $query->recent();
                break;

            default:
                $query->recentReplied();
                break;
        }

        //With 预加载 防止 N+1 问题
        return $query->with('user', 'category');
    }

    public function scopeRecentReplied($query)
    {
        //当话题有新回复时，我们将编写逻辑来更新话题模型的 replu_count  属性
        //此时会自动触发框架对数据模型的  updated_at 时间戳的更新

        return $query->orderBy('updated_at', 'desc');

    }

    public function scopeRecent($query)
    {
        //按照创建时间排序
        return $query->orderBy('created_at',  'desc');
    }

    public function link($params = [])
    {
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function updateReplyCount()
    {
        $this->reply_count = $this->replies->count();
        $this->save();
    }
    
    
}
