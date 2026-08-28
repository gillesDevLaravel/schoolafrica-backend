<?php

namespace Tests\Unit;

use App\Models\Progression;
use App\Models\School;
use App\Models\Tranche;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ModuleTest extends TestCase
{
    use WithFaker;

    public function testCanGetModules()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/modulesall', [
                'idSchool' => School::inRandomOrder()->first()->id,
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanCreateModule()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/modules', [
                'name' => $this->faker->word(),
                'idProgression' => Progression::inRandomOrder()->first()->id,
                'description' => $this->faker->sentence(),
                'idTranche' => Tranche::inRandomOrder()->first()->id,
            ])
            ->assertStatus(201)
            ->assertJsonStructure([
                'data'
            ]);
    }
}
