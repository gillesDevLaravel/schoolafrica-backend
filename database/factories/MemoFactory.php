<?php

use App\Models\Memo;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Memo::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(3),
        'description' => $faker->paragraph(2),
        'type' => $faker->randomElement(['Information', 'Rappel', 'Notification', 'Procédure', 'Directive']),
        'date' => $faker->optional()->date(),
        'image' => $faker->optional()->imageUrl(),
        'created_by' => User::inRandomOrder()->first()->id ?? factory(User::class)->create()->id,
    ];
});
