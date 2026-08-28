<?php

/** @var Factory $factory */

use App\Models\AcademicYear;
use App\Models\ScanReceipt;
use App\Models\School;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(ScanReceipt::class, function (Faker $faker) {
    return [
        'idAcademicYear' => factory(AcademicYear::class)->create()->id,
        'idSchool' => School::first()->id,
        'idStudent' => User::inRandomOrder()->first()->id,
        'image_scan' => $this->faker->name,
        'created_by' => User::inRandomOrder()->first()->id,
    ];
});
