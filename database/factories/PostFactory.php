<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use App\User;
use Faker\Generator as Faker;

$factory->define(App\Models\Post::class, function (Faker $faker) {
    $count = User::count();

    return [
        "title" => $faker->text($maxNbChars = 20),
        "content" => $faker->text($maxNbChars = 200),
        "user_id" => $faker->numberBetween(1, $count)
    ];
});
