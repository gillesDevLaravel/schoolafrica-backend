<?php

/** @var Factory $factory */

use App\Models\Article;
use App\Models\ArticleMovement;
use App\Models\Rental;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Rental::class, function (Faker $faker) {

    $articleMovement = factory(ArticleMovement::class)->create(['stock' => 15]);
    $article = $articleMovement->article;
    return [
        'user_id'         => function () {
            return factory(User::class)->create()->id;
        },
        'article_id'      => $article->id,
        'description'     => $faker->sentence,
        'reason'          => $faker->sentence,
        'exit_quantity'   => $faker->numberBetween(1, 10),
        'exit_date'       => $faker->dateTimeBetween('-10 days', 'now'),
        'exit_condition'  => $faker->randomElement(['Neuf', 'Bon état', 'Abimé']),
        'exit_image'      => $faker->imageUrl(),

        'entry_quantity'  => $faker->numberBetween(0, 10),
        'entry_date'      => $faker->optional()->dateTimeBetween('now', '+10 days'),
        'entry_condition' => $faker->optional()->randomElement(['Neuf', 'Bon état', 'Cassé']),
        'entry_image'     => $faker->optional()->imageUrl(),

        'created_by'      => function () {
            return auth()->id() ?? factory(User::class)->create()->id;
        },
        'updated_by'      => null,
    ];
});
