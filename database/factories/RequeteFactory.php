<?php

/** @var Factory $factory */

use App\Models\Requete;
use App\Models\School;
use App\Models\Section;
use App\Models\TypeRequete;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Requete::class, function (Faker $faker) {
    return [
        'categorie'    => $faker->randomElement(['interne', 'externe']),
        'description'  => $faker->sentence(),
        'statut'       => 'pending',
        'idTypeRequete' => TypeRequete::inRandomOrder()->first()->id ?? factory(TypeRequete::class)->create()->id,
        'idUser'       => User::inRandomOrder()->first()->id ?? null,
        'idSection'    => Section::inRandomOrder()->first()->id ?? null,
        'idSchool'     => School::inRandomOrder()->first()->id ?? null,
        'created_by'   => User::inRandomOrder()->first()->id ?? null,
    ];
});
