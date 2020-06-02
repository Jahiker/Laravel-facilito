<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comment;
use App\Models\Post;
use App\User;
use Faker\Generator as Faker;

$factory->define(App\Models\Comment::class, function (Faker $faker) {
    $posts = App\Models\Post::count();
    $users = User::count();

    return [
        "content" => $faker->text($maxNbChars = 200),
        "user_id" => $faker->numberBetween(1, $users),
        "post_id" => $faker->numberBetween(1, $posts),
    ];
});
