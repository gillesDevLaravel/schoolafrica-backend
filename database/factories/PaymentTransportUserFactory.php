<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\PaymentTransportUser;
use App\Models\TransportUser;
use Faker\Generator as Faker;

$factory->define(PaymentTransportUser::class, function (Faker $faker) {
    return [
        'transport_user_id'  => factory(TransportUser::class)->create()->id,
        'advance_payment'    => $faker->randomFloat(2, 0, 200),
        'balance_payment'    => $faker->randomFloat(2, 0, 800),
        'payment_date'       => $faker->date(),
        'payment_mode'       => $faker->randomElement(['Cash', 'Cheque', 'Mobile Money', 'Orange Money']),
        'solvable'           => $faker->randomElement(['oui', 'non']),
        'scan_receipt'       => $faker->optional()->lexify('receipt_????.pdf'),
        'photo'              => $faker->optional()->imageUrl(200, 200, 'people'),
        'reason'             => $faker->optional()->sentence,
        'receipt_number'     => $faker->optional()->numerify('RCPT-#####'),
        'telephone'          => $faker->optional()->phoneNumber,
        'reference'          => $faker->optional()->regexify('[A-Z0-9]{7}'),
        'created_by'         => 1, // ou factory(User::class)
        'updated_by'         => null,
        'deleted_by'         => null,
    ];
});
