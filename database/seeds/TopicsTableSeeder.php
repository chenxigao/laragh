<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\User;
use App\Models\Category;

class TopicsTableSeeder extends Seeder
{
    public function run()
    {

        //取出所有用户 id 数组，如 [1,2.3.4]
        $user_ids = User::all()->pluck('id')->toArray();

        //取出所有分类 id 数组， 如： [1,2.3,4]
        $category_ids = Category::all()->pluck('id')->toArray();

        //获取Faker 实例
        $faker = app(Faker\Generator::class);

        $topics = factory(Topic::class)
                    ->times(100)
                    ->make()
                    ->each(function ($topic, $index)
                    use ($user_ids, $category_ids, $faker){
                        //从用户 id 数组中随机取出一个并赋值
                        $topic->user_id = $faker->randomElement($user_ids);

                        //从分类 id 数组中 随机取出一个并赋值
                        $topic->category_id = $faker->randomElement($category_ids);
                    });


        //将数据集合转换为数组并插入数据库中
        Topic::insert($topics->toArray());
    }

}

