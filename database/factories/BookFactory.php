<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'title' => $faker->paragraph,
        'author_id' => [
            'name' => $faker->firstName .' '. $faker->lastName,
            'dob' => now()->subYears(rand(10,20))
        ]
    ];
});
