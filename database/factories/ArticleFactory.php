<?php

/** @var Factory $factory */

use App\Enums\ArticleTypeEnum;
use App\Models\Article;
use App\Models\School;
use App\Models\Section;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'reference'            => generateReferenceNumber(Article::class, 'reference', 6),
        'idSchool'                 => School::inRandomOrder()->first(),
        'idSection'                 => Section::inRandomOrder()->first(),
        'name'                 => $faker->word,
        'unit_of_measurement' => $faker->randomElement(['kg', 'L', 'pcs']),
        'description'          => $faker->sentence,
        'alert_quantity'       => $faker->numberBetween(1, 20),
        'price'                => $faker->randomFloat(2, 5, 500),
        'type'                 => $faker->randomElement(ArticleTypeEnum::values()),
        'image'                => null, // ou $faker->imageUrl() si tu veux une image fake
        'expiry_date'          => $faker->optional()->dateTimeBetween('now', '+2 years'),
        'container'            => $faker->word,
        'container_unit'       => $faker->randomElement(['L', 'kg', 'box']),
        'container_quantity'   => $faker->numberBetween(1, 100),
        'detail'               => $faker->paragraph,
        'created_by'           => User::inRandomOrder()->first()->id ?? factory(User::class),
    ];
});
