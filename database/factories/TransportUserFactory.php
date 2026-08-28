<?php

/** @var Factory $factory */

use App\Models\TransportUser;
use App\Models\Transport;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(TransportUser::class, function (Faker $faker) {
    return [
        'transport_id' => function () {
            return factory(Transport::class)->create()->id;
        },
        'student_id'   => function () {
            return factory(User::class)->create()->id;
        },
        'type'         => $faker->randomElement(['monthly', 'termly', 'yearly']),
        'amount'         => $faker->randomFloat(2, 200, 1000),
        'reduction'         => $faker->randomElement([true, false]),
        'reduction_amount'         => $faker->randomFloat(2, 200, 1000),
        'reason'         => $faker->optional()->sentence
    ];
});
