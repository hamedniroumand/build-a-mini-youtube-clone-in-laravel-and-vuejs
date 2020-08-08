<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user1 = factory(\App\User::class)->create([
            "email" => "john@doe.com",
        ]);

        $user2 = factory(\App\User::class)->create([
            "email" => "jane@doe.com",
        ]);

        $channel1 = factory(\App\Channel::class)->create([
            "user_id" => $user1->id
        ]);

        $channel2 = factory(\App\Channel::class)->create([
            "user_id" => $user2->id
        ]);

        $channel1->subscriptions()->create([
             "user_id" => $user2->id
        ]);

        $channel2->subscriptions()->create([
             "user_id" => $user1->id
        ]);

        factory(\App\Subscription::class,1050)->create([
            "channel_id" => $channel1->id
        ]);

        factory(\App\Subscription::class,1050)->create([
            "channel_id" => $channel2->id
        ]);

        $video = factory(\App\Video::class)->create([
            "channel_id" => $channel1->id
        ]);

        factory(\App\Comment::class, 50)->create([
            "video_id" => $video->id
        ]);

        $comment = \App\Comment::first();

        factory(\App\Comment::class, 40)->create([
            "video_id" => $video->id,
            "comment_id" => $comment->id
        ]);
    }
}
