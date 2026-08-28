<?php

namespace Tests\Unit;

use App\Models\OptionLevel;
use App\Models\School;
use App\Models\Section;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OptionLevelTest extends TestCase
{
    use WithFaker;

    public function testCanCreateOptionLevels()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $optionlevels = [
            [
                'name' => $this->faker->name,
                'idSchool' => 1,
//                'idSection' => 1,
                'idFiliere' => 1,
                'description' => $this->faker->text(20),
                'lang' => $this->faker->languageCode,
            ],
            [
                'name' => $this->faker->name,
                'idSchool' => 1,
                'idSection' => 1
            ],
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/optionlevels', [
                'optionlevels' => $optionlevels
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanUpdateOptionLevel()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $optionlevel = OptionLevel::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/optionlevels/{$optionlevel->id}", [
                'name' => $this->faker->name,
                'idSchool' => School::inRandomOrder()->first()->id,
                'idSection' => Section::inRandomOrder()->first()->id
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }
}
