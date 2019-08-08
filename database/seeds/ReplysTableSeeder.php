<?php

use Illuminate\Database\Seeder;
use App\Models\Reply;
use App\Models\User;
use App\Models\Topic;

class ReplysTableSeeder extends Seeder
{
    public function run()
    {
        //取出所有用户 ID 数组，如[1,2,3,4]
        $user_ids = User::all()->pluck('id')->toArray();

        //取出所有话题 ID 数组，如[1,2,3,4]
        $topic_ids = Topic::all()->pluck('id')->toArray();

        //获取 faker 实例
        $faker = app(Faker\Generator::class);

        $replys = factory(Reply::class)
            ->times(1000)
            ->make()
            ->each(function ($reply, $index) use ($user_ids, $topic_ids, $faker){
                //从用户 id 数组中随机取出一个并赋值
                $reply->user_id = $faker->randomElement($user_ids);
                //从话题 id数组中随机取出一个并赋值
                $reply->topic_id = $faker->randomElement($topic_ids);

            });

        //将集合转化为数组并插入数据中
        Reply::insert($replys->toArray());
    }

}

