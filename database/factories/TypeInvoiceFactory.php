<?php

/** @var Factory $factory */

use App\Models\School;
use App\Models\TypeInvoice;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(TypeInvoice::class, function (Faker $faker) {
    return [
        'name'       => $faker->word(),
        'code'       => strtoupper($faker->lexify('???')),
        'category'   => $faker->word(),
        'school_id'  => School::inRandomOrder()->first()->id ?? null,
        'created_by' => User::inRandomOrder()->first()->id ?? null,
    ];
});
