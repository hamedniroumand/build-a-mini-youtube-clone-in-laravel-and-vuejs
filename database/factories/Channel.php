<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Channel::class, function (Faker $faker) {
    return [
        "name" => $faker->sentence(3),
        "description" => $faker->sentence(30),
        "user_id" => function(){
            return factory(\App\User::class)->create()->id;
        },
    ];
});
