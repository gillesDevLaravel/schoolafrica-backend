<?php

namespace Tests\Unit;

use App\Models\Cycle;
use App\Models\Level;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LevelTest extends TestCase
{
    use WithFaker;

    public function testCanCreateLevel()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $levels = [
            [
                'name' => $this->faker->name,
                'idCycle' => 1,
                'idSchool' => 1,
//                'idSection' => 1,
                'description' => $this->faker->text(20),
            ],
            [
                'name' => $this->faker->name,
                'idCycle' => 2,
                'idSchool' => 2,
                'idSection' => 2,
                'description' => $this->faker->text(20),
            ],
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/levels', [
                'levels' => $levels
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanUpdateLevel()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $level = Level::latest()->first();
//        $cycle = Cycle::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/levels/{$level->id}", [
                'name' => $this->faker->name,
//                'idCycle' => $cycle->id,
                'description' => $this->faker->text(20),
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }
}
