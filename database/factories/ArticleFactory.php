<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->catchPhrase,
        'content' => $faker->text,
        'featured_image' => $faker->image('public/images',750,300, null, false),
        
    ];
});
