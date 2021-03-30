<?php

use Illuminate\Database\Seeder;
use App\Models\Reply;
use App\Models\Topic;
use App\Models\User;

class RepliesTableSeeder extends Seeder
{
    public function run()
    {

        $users_id = User::all()->pluck('id')->toArray();
        $topics_id = Topic::all()->pluck('id')->toArray();
        $faker = app(Faker\Generator::class);

        $replies = factory(Reply::class)->times(500)->make()
            ->each(function ($reply, $index) use($faker,$users_id,$topics_id) {

                //随机赋值
                $reply->user_id = $faker->randomElement($users_id);
                $reply->topic_id = $faker->randomElement($topics_id);
        });

        Reply::insert($replies->toArray());
    }

}

