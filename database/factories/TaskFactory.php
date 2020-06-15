<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Tasks;
use App\User;
use Faker\Generator as Faker;

$factory->define(Tasks::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(5),
        'description' => $faker->realText(200),
        'status_id' => $faker->randomElement([1, 2, 3]),
        'created_by_user_id' =>$faker->randomElement(User::pluck('user_id', 'user_id')->toArray()) ,
        'assign_user_id' => $faker->randomElement(User::pluck('user_id', 'user_id')->toArray()),
        'created_at' => $faker->dateTimeBetween('-30 days', 'now'),
        'updated_at' => $faker->dateTimeBetween('-10 days', 'now'),
    ];
});
