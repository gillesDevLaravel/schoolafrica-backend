<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enums\SupplyDemandPriorityEnum;
use App\Enums\SupplyDemandStatusEnum;
use App\Models\Article;
use App\Models\SupplyDemand;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(SupplyDemand::class, function (Faker $faker) {
    $user = User::inRandomOrder()->first() ?? factory(User::class)->create();

    return [
        'reference' => generateReferenceNumber(SupplyDemand::class, 'reference', 6),
        'name' => $faker->word,
        'description' => $faker->text(15),
        'responsible_id' => $user->id,
        'status' => $faker->randomElement(SupplyDemandStatusEnum::values()),
        'priority' => $faker->randomElement(SupplyDemandPriorityEnum::values()),
        'created_by' => $user->id,
        'updated_by' => $user->id,
    ];
});
