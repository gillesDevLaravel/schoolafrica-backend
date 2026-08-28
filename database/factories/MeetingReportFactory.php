<?php

use App\Models\MeetingReport;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(MeetingReport::class, function (Faker $faker) {
    return [
        'name'        => $faker->sentence(3),
        'type'        => $faker->randomElement(['Conseil d\'Administration', 'Réunion Technique', 'Réunion Équipe', 'Assemblée Générale', 'Réunion Pédagogique']),
        'description' => $faker->optional()->sentence(10),
        'date'        => $faker->optional()->date('Y-m-d'),
        'participants' => $faker->name . ', ' . $faker->name,
        'created_by'  => User::inRandomOrder()->first()->id ?? factory(User::class),
    ];
});
