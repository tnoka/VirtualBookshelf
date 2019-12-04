<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'id' => $faker->id,
        'title' => $faker->title,
        'recommend' => "★★★★★",
        'text' => $faker->text,
        'product_image' => str_random(40) . '.jpg',
        'user_id' => function(){return factory(App\User::class)->create()->id;},
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
