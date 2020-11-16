<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->catchPhrase,
        'category_id' => $faker->numberBetween($min = 1, $max = 4),
        'id_admin' => $faker->numberBetween($min = 1, $max = 1),
        'content' => $faker->text,
        'featured_image' => $faker->image('public/storage/articleImages',750,300, null, false),
    ];
});
