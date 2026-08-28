<?php

/** @var Factory $factory */

use App\Enums\ArticleTypeEnum;
use App\Enums\PurchaseOrderPaymentMethodEnum;
use App\Enums\PurchaseOrderPriorityEnum;
use App\Enums\PurchaseOrderStatusEnum;
use App\Models\Article;
use App\Models\PurchaseOrder;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(PurchaseOrder::class, function (Faker $faker) {

    $supplier = User::inRandomOrder()->first();
    $responsible = User::inRandomOrder()->first();
    $createdBy = User::inRandomOrder()->first();

    return [
        'reference' => generateReferenceNumber(PurchaseOrder::class, 'reference', 6),
        'supplier_id' => $supplier->id,
        'responsible_id' => $responsible->id,
        'description' => $this->faker->sentence,
        'status' => $this->faker->randomElement(PurchaseOrderStatusEnum::values()),
        'payment_method' => $this->faker->randomElement(PurchaseOrderPaymentMethodEnum::values()),
        'priority' => $this->faker->randomElement(PurchaseOrderPriorityEnum::values()),
        'created_by' => $createdBy->id,
        'validation_date' => $this->faker->optional()->dateTimeThisYear,
        'order_received_date' => $this->faker->optional()->dateTimeThisYear,
    ];
});
