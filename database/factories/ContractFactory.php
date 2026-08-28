<?php

use App\Models\Contract;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(Contract::class, function (Faker $faker) {
    $user = User::inRandomOrder()->first()->id;

    Contract::where('idUser', $user)->where('status', '!=', 'terminated')->delete();
    return [
        "reference" => generateReferenceNumber(Contract::class, "reference", 6),
        'idUser' => $user,
        'idUserApprove' => User::inRandomOrder()->first()->id,
        'type' => $faker->randomElement(['CDD', 'CDI', 'Stage', 'Freelance']),
        'description' => $faker->optional()->sentence(),
        'start_date' => $faker->date(),
        'duration' => $faker->randomElement([6, 12, 24, 36]), // en mois
        'working_hours' => $faker->time('H:i') . '-' . $faker->time('H:i', '+8 hours'),
        'position' => $faker->jobTitle(),
        'gross_salary' => $faker->randomFloat(2, 2000, 10000),
        'status' => $faker->randomElement(['pending_approval', 'approved', 'terminated']),
        'service_benefits' => $faker->optional()->sentence(),
        'bonus' => $faker->optional()->randomFloat(2, 100, 2000),
        'number_days_off' => $faker->numberBetween(0, 30),
        'created_by' => User::inRandomOrder()->first()->id, // Remplace par un ID valide ou change en `auth()->id()`
    ];
});
