<?php

namespace Tests\Unit;

use App\Models\Semestre;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SemestreTest extends TestCase
{
    use WithFaker;
    // IMPORTANT : tu n'utilises pas RefreshDatabase car tu fais login à chaque requête.
    // Il faut éviter de wipe la DB sinon ton user 'fondateur' disparaît.

    /**
     * Login helper
     */
    public function authHeaders()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $token = json_decode($login->getContent())->data->token;

        return ['Authorization' => 'Bearer ' . $token];
    }

    /** @test */
    public function testCanListSemestres()
    {
        // Arrange
        factory(Semestre::class, 3)->create();

        // Act
        $response = $this->withHeaders($this->authHeaders())
            ->postJson('/api/semestresall', []);

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name']
                ]
            ]);
    }

    /** @test */
    public function testCanCreateSemestres()
    {
        $payload = [
            'semestres' => [
                ['name' => "Semestre " . $this->faker->word],
                ['name' => "Semestre " . $this->faker->word]
            ]
        ];

        $response = $this->withHeaders($this->authHeaders())
            ->postJson('/api/semestres', $payload);

        dd($response->getContent());

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => ['id', 'name']
                ],
                'message'
            ]);
    }

    /** @test */
    public function testCanShowSemestre()
    {
        $semestre = factory(Semestre::class)->create();

        $response = $this->withHeaders($this->authHeaders())
            ->getJson('/api/semestres/' . $semestre->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => ['id', 'name']
            ]);
    }

    /** @test */
    public function testCanUpdateSemestre()
    {
        $semestre = factory(Semestre::class)->create();

        $payload = [
            'name' => "Updated " . $this->faker->word
        ];

        $response = $this->withHeaders($this->authHeaders())
            ->putJson('/api/semestres/' . $semestre->id, $payload);

        $response->assertStatus(200)
            ->assertJson([
                'data' => ['name' => $payload['name']]
            ]);
    }

    /** @test */
    public function testCanDeleteSemestre()
    {
        $semestre = factory(Semestre::class)->create();

        $response = $this->withHeaders($this->authHeaders())
            ->deleteJson('/api/semestres/' . $semestre->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('semestres', ['id' => $semestre->id]);
    }

    /** @test */
    public function testCannotDeleteNonExistingSemestre()
    {
        $response = $this->withHeaders($this->authHeaders())
            ->deleteJson('/api/semestres/999999');

        $response->assertStatus(500)
            ->assertJsonStructure([
                'success',
                'message'
            ]);
    }
}
