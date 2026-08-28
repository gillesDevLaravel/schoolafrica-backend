<?php

/** @var Factory $factory */

use App\Enums\ArticleMovementOperationTypeEnum;
use App\Enums\ArticleTypeEnum;
use App\Models\Article;
use App\Models\ArticleMovement;
use App\Models\School;
use App\Models\Section;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(ArticleMovement::class, function (Faker $faker) {
    $article = factory(Article::class)->create();
    $user = factory(User::class)->create();

    return [
        'quantity' => $faker->numberBetween(1, 10),
        'reason' => $faker->sentence,
        'date' => $faker->dateTimeThisMonth,
        'description' => $faker->sentence,
        'operation_type' => $faker->randomElement(ArticleMovementOperationTypeEnum::values()),
        'article_id' => $article->id,
        'purchase_order_id' => null,
        'created_by' => $user->id,
        'user_id' => $user->id,
        'stock' => $faker->numberBetween(0, 100),
    ];
});
