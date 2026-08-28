<?php

namespace Tests\Unit;

use App\Models\Cycle;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CycleTest extends TestCase
{
    use WithFaker;

    public function testCanCreateCycle()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $cycles = [
            [
                'name' => $this->faker->name,
                'idSchool' => 1,
//                'idSection' => 1,
                'description' => $this->faker->text(20),
            ],
            [
                'name' => $this->faker->name,
                'idSchool' => 2,
                'idSection' => 2,
                'description' => $this->faker->text(20),
            ],
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/cycles', [
                'cycles' => $cycles
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanUpdateCycle()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $cycle = Cycle::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/cycles/{$cycle->id}", [
                'name' => $this->faker->name,
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }
}
