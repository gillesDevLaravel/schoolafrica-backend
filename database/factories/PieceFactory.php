<?php

use App\Models\Piece;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Piece::class, function (Faker $faker) {
    return [
        'name'        => $faker->word,
        'etage'       => $faker->randomElement(['RDC', '1er', '2ème', '3ème']),
        'description' => $faker->optional()->sentence,
        'status'      => $faker->randomElement(['active', 'inactive']),
        'created_by'           => User::inRandomOrder()->first()->id ?? factory(User::class),
    ];
});
