<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Business;
use Faker\Generator as Faker;

$factory->define(Business::class, function (Faker $faker) {
    return [
        'business_name' => $faker->unique()->word,
        'rating' => $faker->numberBetween(1,5),
        'description' => $faker->text,
        'address' => $faker->address,
        'phone' => $faker->unique()->phoneNumber,
        'email' => $faker->unique()->email,
        'active' => $faker->boolean,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
