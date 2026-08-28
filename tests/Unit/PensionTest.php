<?php

namespace Tests\Unit;

use App\Models\Pension;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PensionTest extends TestCase
{
    use WithFaker;

    public function testCanGetPensions(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/pensionsall', [
                'idSchool' => 2
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }
    public function testCannotGetPensionsWithMissingParam(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/pensionsall', [])
            ->assertStatus(422)
            ->assertJsonStructure([
                'success', 'message'
            ]);
    }

    public function testCanCreateMultiplePensionsInBulk()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/pensions', [
                'pensions' => [
                    [
                        "price" => 80000,
                        "nbrTranche" => 3,
                        "idLevel" => 1
                    ],
                    [
                        "name" => "Pension Info L2",
                        "price" => 70000,
                        "nbrTranche" => 3,
                        "idLevel" => 2
                    ]
                ]
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'success', 'data', 'message'
            ]);
    }

    public function testCannotCreateMultiplePensionsWithMissingParam()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/pensions', [
                'pensions' => [
                    [
                        "name" => "Pension Info L1",
                        "price" => 50000,
                        "nbrTranche" => 2,
                        "idLevel" => 1
                    ],
                    [
                        "name" => "Pension Info L2",
                        "nbrTranche" => 2,
                        "idLevel" => 2
                    ]
                ]
            ])
            ->assertStatus(422)
            ->assertJsonStructure([
                'success', 'message'
            ]);
    }

    public function testCanUpdatePension()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $pension = Pension::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/pensions/{$pension->id}", [
                "name" => $this->faker->name
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanDeletePension()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $pension = Pension::create([
            'name' => $this->faker->name,
            'price' => 80000,
            'nbrTranche' => 3,
            'idLevel' => 1,
            'idSchool' => 2,
            'idSection' => 2,
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->delete("/api/pensions/{$pension->id}")
            ->assertStatus(200);

        $pension->update([
            'deleted' => false
        ]);
    }
}
