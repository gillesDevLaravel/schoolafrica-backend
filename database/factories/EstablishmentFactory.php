<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Establishment;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Establishment::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'ministry' => $faker->word,
        'region' => $faker->city,
        'department' => $faker->word,
        'phone' => $faker->phoneNumber,
        'mobile_money_number' => $faker->numerify('### ### ### ###'),
        'rib' => $faker->numerify('####################'),
        'cnps' => $faker->numerify('#########'),
        'banque' => $faker->company,
        'om' => $faker->numerify('#########'),
        'country' => 'Cameroun',
        'email' => $faker->companyEmail,
        'idPackage' => 1,
        'pay_om_fees' => false,
        'idFounder' => null,
        'created_by' => null,
//        'deleted' => 0,
    ];
});
