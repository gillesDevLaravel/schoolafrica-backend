<?php

namespace Tests\Unit;

use App\Models\Course;
use App\Models\Trimestre;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TrimestreTest extends TestCase
{
    use WithFaker;

    public function testCanGetAllTrimestres()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $absences = [
            [
                'type' => "student",
                'date' => "2024-09-30",
                'idCourse' => Course::where('idClasse', 10)->first()->id,
                'idStudent' => 927,
            ]
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/trimestresall', [
                'absences' => $absences,
            ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'numbering',
                        'idSchool',
                        'idSection',
                        'semestre',
                        'takenIntoAccount'
                    ]
                ]
            ]);
    }

    public function testCanCreateManyTrimestres()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $trimestres = [
            [
                'name' => "Merde",
                'numbering' => $this->faker->numberBetween(1, 3),
                'idSchool' => 2,
                'idSection' => 2,
                'idSemestre' => 1,
                'takenIntoAccount' => $this->faker->boolean
            ]
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/trimestres', [
                'trimestres' => $trimestres,
            ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
                'message',
            ]);
    }

    public function testCanUpdateTrimestre()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $t = Trimestre::latest()->first();

        $newName = $this->faker->word;
        $newNumbering = $this->faker->numberBetween(1, 3);
        $newTakenIntoAccount = $this->faker->boolean;

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/trimestres/{$t->id}", [
                'name' => $newName,
                'numbering' => $newNumbering,
                'takenIntoAccount' => $newTakenIntoAccount
            ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
            ])
            ->assertJson([
                'data' => [
                    'name' => $newName,
                    'numbering' => $newNumbering,
                    'takenIntoAccount' => $newTakenIntoAccount
                ]
            ]);
    }

    public function testCanDeleteTrimestre()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $t = Trimestre::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->deleteJson("/api/trimestres/{$t->id}")
            ->assertStatus(200);
    }

    public function testCannotDeleteUnexistingTrimestre()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->deleteJson("/api/trimestres/9999")
            ->assertStatus(404)
            ->assertJsonStructure([
                'success',
                'message'
            ]);
    }
}
