<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Video::class, function (Faker $faker) {
    return [
        "channel_id" => function(){
            return factory(\App\Channel::class)->create()->id;
        },
        "views" => $faker->numberBetween(15, 25000),
        "thumbnail" => $faker->imageUrl(),
        'percentage' => 100,
        "title" => $faker->sentence(4),
        "description" => $faker->paragraph(2),
        "path" => $faker->word()
    ];
});
