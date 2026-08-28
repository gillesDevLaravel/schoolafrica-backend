<?php

namespace Tests\Unit;

use App\Models\Sanction;
use App\Models\School;
use App\Models\Section;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SectionTest extends TestCase
{
    use WithFaker;

    public function test_can_get_sections()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/sectionsall')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_create_section()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/sections', [
                'idSchool' => School::first()->id,
                'description' => $this->faker->sentence,
                'name' => $this->faker->name,
                'lang' => $this->faker->randomElement(['fr', 'en'])
            ])
            ->assertStatus(201)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_update_section()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $section = Section::create([
            'idSchool' => School::first()->id,
            'description' => $this->faker->sentence,
            'name' => $this->faker->name,
            'lang' => $this->faker->randomElement(['fr', 'en'])
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/sections/{$section->id}", [
                'idSchool' => School::first()->id,
                'description' => $this->faker->sentence,
                'name' => $this->faker->name,
                'lang' => $this->faker->randomElement(['fr', 'en'])
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        $section->delete();
    }

    public function test_can_delete_section()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $section = Section::create([
            'idSchool' => School::first()->id,
            'description' => $this->faker->sentence,
            'name' => $this->faker->name,
            'lang' => $this->faker->randomElement(['fr', 'en'])
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->delete("/api/sections/{$section->id}")
            ->assertStatus(200);
    }
}
