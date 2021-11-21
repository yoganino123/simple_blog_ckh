<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\News;
use Faker\Generator as Faker;

$factory->define(News::class, function (Faker $faker) {
    return [
        'title' => $faker->text,
        'content' => $faker->paragraph,
        'category_id' => rand(1, 3)
    ];
});
