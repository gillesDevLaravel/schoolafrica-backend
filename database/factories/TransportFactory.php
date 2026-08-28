<?php

/** @var Factory $factory */

use App\Models\Transport;
use Faker\Generator as Faker;

$factory->define(Transport::class, function (Faker $faker) {
    return [
        'name'           => $faker->word,
        'remark'    => $faker->optional()->sentence,
        'description'    => $faker->optional()->sentence,
        'amount_month'   => $faker->optional()->randomFloat(2, 100, 500),
        'amount_terms1'  => $faker->optional()->randomFloat(2, 50, 300),
        'amount_terms2'  => $faker->optional()->randomFloat(2, 50, 300),
        'amount_terms3'  => $faker->optional()->randomFloat(2, 50, 300),
        'amount'         => $faker->randomFloat(2, 200, 1000),
    ];
});
