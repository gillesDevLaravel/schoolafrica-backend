<?php

namespace Tests\Unit;

use App\Models\Course;
use App\Models\Level;
use App\Models\Pension;
use App\Models\School;
use App\Models\Tranche;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TrancheTest extends TestCase
{
    use WithFaker;

    public function testCanGetTranches()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/tranchesall', [
                'idSchool' => 1
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanCreateTranches()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $pension = Pension::create([
            'name' => $this->faker->name,
            'price' => 50000,
            'nbrTranche' => 1,
            'idLevel' => Level::inRandomOrder()->first()->id,
            'idSchool' => School::inRandomOrder()->first()->id
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/tranches', [
                'tranches' => [
                    [
                        'idPension' => $pension->id,
                        'name' => $this->faker->name,
                        'price' => 5000,
                        'deadline' => "2030-12-31"
                    ],
                ]
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        $pension->delete();
        Tranche::latest()->first()->delete();
    }

    public function testCanDeleteTranche()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $trancheTest = Tranche::create([
            'name' => $this->faker->word,
            'price' => $this->faker->numberBetween(1000, 999999),
            'deadline' => $this->faker->date(),
            'idPension' => 1,
            'idSchool' => 1,
            'idSection' => 1
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->delete("/api/tranches/$trancheTest->id")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        $trancheTest->update([
            'deleted' => false
        ]);
    }
}
