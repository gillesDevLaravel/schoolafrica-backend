<?php

namespace Tests\Unit;

use App\Models\Litige;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LitigeTest extends TestCase
{
    use WithFaker;

    /**
     * Connexion utilitaire pour récupérer un token valide
     */
    private function authenticate(): string
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000',
        ]);

        return json_decode($login->getContent())->data->token;
    }

    /**
     * Vérifie la liste des litiges avec filtres et pagination
     */
    public function test_can_list_litiges_with_filters_and_pagination(): void
    {
        $token = $this->authenticate();

        // Création de litiges de test
        factory(Litige::class, 5)->create();

        // Appel de l’API avec filtre
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])
            ->postJson('/api/litigesall');

        // Vérification de la structure paginée
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'answer',
                        'created_at',
                    ],
                ],
                'links',
                'meta',
            ]);
    }

    /**
     * Vérifie la création d’un litige
     */
    public function test_can_create_litige(): void
    {
        $token = $this->authenticate();

        $data = [
            'name'        => $this->faker->sentence(3),
            'description' => $this->faker->sentence,
            'answer'      => $this->faker->optional()->sentence,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])
            ->postJson('/api/litiges', $data);

        // Vérification réponse API
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        // Vérification insertion en base
        $this->assertDatabaseHas('litiges', [
            'name' => $data['name'],
        ]);
    }

    /**
     * Vérifie l’affichage d’un litige précis
     */
    public function test_can_show_litige(): void
    {
        $token = $this->authenticate();

        $litige = factory(Litige::class)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])
            ->getJson("/api/litiges/{$litige->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id'          => $litige->id,
                    'name'        => $litige->name,
                    'description' => $litige->description,
                ],
            ]);
    }

    /**
     * Vérifie la mise à jour d’un litige
     */
    public function test_can_update_litige(): void
    {
        $token = $this->authenticate();

        $litige = factory(Litige::class)->create();

        $updateData = [
            'answer' => 'Résolu',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])
            ->putJson("/api/litiges/{$litige->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'answer' => $updateData['answer'],
                ],
            ]);

        $this->assertDatabaseHas('litiges', [
            'id'     => $litige->id,
            'answer' => $updateData['answer'],
        ]);
    }

    /**
     * Vérifie l’archivage (soft delete) d’un litige
     */
    public function test_can_archive_litige(): void
    {
        $token = $this->authenticate();

        $litige = factory(Litige::class)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])
            ->postJson('/api/litiges/trash', [
                'ids' => [$litige->id],
            ]);

        $response->assertStatus(204);

        $this->assertSoftDeleted('litiges', [
            'id' => $litige->id,
        ]);
    }

    /**
     * Vérifie la restauration d’un litige archivé
     */
    public function test_can_restore_litige(): void
    {
        $token = $this->authenticate();

        $litige = factory(Litige::class)->create();
        $litige->delete();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])
            ->postJson('/api/litiges/restore', [
                'ids' => [$litige->id],
            ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'success' => true,
            ]);

        $this->assertDatabaseHas('litiges', [
            'id'         => $litige->id,
            'deleted_at'=> null,
        ]);
    }

    /**
     * Vérifie la suppression définitive d’un litige
     */
    public function test_can_delete_litige_permanently(): void
    {
        $token = $this->authenticate();

        $litige = factory(Litige::class)->create();
        $litige->delete();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])
            ->postJson('/api/litiges/delete', [
                'ids' => [$litige->id],
            ]);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('litiges', [
            'id' => $litige->id,
        ]);
    }
}
