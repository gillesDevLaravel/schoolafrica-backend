<?php

namespace Tests\Unit;

use App\Models\OptionLevel;
use App\Models\School;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MatterTest extends TestCase
{
    use WithFaker;

    public function testCanGetMatters()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/mattersall', [
                'idSchool' => School::inRandomOrder()->first()->id,
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanCreateMatter()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/matters', [
                'code' => $this->faker->randomNumber(),
                'libelle' => $this->faker->word(),
                'name' => $this->faker->word(),
                'idSchool' => School::inRandomOrder()->first()->id,
//                'idSection' => 2,
                'idOptionLevel' => OptionLevel::inRandomOrder()->first()->id,
                'description' => $this->faker->sentence(),
            ])
            ->assertStatus(201)
            ->assertJsonStructure([
                'data'
            ]);
    }
}
