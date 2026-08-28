<?php

namespace Tests\Unit;

use App\Models\TypeEvaluation;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TypeEvaluationTest extends TestCase
{
    use WithFaker;

    public function testCanGetAllTypeEvaluation()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/typeevaluationsall', [
                'idSchool' => 1,
                "idSection" => null
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanCreateTypeEvaluation()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/typeevaluations', [
                'name' => $this->faker->word,
                'libelle' => $this->faker->text(100)
            ])
            ->assertStatus(201)
            ->assertJsonStructure([
                'data',
            ]);
    }

    public function testCanUpdateTypeEvaluation()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $te = TypeEvaluation::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/typeevaluations/{$te->id}", [
                'name' => $this->faker->word,
//                'libelle' => $this->faker->text(100)
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
            ]);
    }

    public function testCanDeleteTypeEvaluation()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $te = TypeEvaluation::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->deleteJson("/api/typeevaluations/{$te->id}")
            ->assertStatus(200);
    }
}
