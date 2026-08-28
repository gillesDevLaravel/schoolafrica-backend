<?php

namespace Tests\Unit;

use App\Models\Level;
use App\Models\Matter;
use App\Models\OptionLevel;
use App\Models\School;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MatterGroupTest extends TestCase
{
    use WithFaker;

    public function testCanGetMatterGroups()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/mattergroupsall', [
                'idSchool' => School::inRandomOrder()->first()->id,
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanCreateMatterGroup()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/mattergroups', [
                'name' => $this->faker->word(),
                'idSchool' => School::inRandomOrder()->first()->id,
                'idOptionLevel' => OptionLevel::inRandomOrder()->first()->id,
                'description' => $this->faker->sentence(),
                'levels' => Level::inRandomOrder()->take(rand(1,3))->pluck('id'),
                'matter' => Matter::inRandomOrder()->take(rand(1,3))->pluck('id'),
            ])
            ->assertStatus(201)
            ->assertJsonStructure([
                'data'
            ]);
    }
}
