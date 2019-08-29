<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Link extends Model
{
    protected $fillable = ['title', 'link'];
    public $cache_key = 'larabbs:links';
    protected $cache_expire_in_seconds = 1440*60;

    public function getAllCached()
    {
        //尝试从缓存中取出 cache_key对应的数据，如果能取到，则直接返回数据
        //否则运行匿名函数中的代码取出 links 表中所有数据，返回的同事并作缓存
        return Cache::remember($this->cache_key, $this->cache_expire_in_seconds, function ()
        {
            return $this->all();
        });
    }
}
