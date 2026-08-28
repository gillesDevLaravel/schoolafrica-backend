<?php

namespace Tests\Unit;

use App\Models\ArticleMovement;
use App\Models\Rental;
use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RentalTest extends TestCase
{
    use WithFaker;

    public function test_can_list_rentals_with_filters_and_pagination()
    {
        // Connexion avec un utilisateur autorisé
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        // Préparation des données
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();

        factory(Rental::class, 5)->create([
            'article_id' => $article->id,
            'user_id' => $user->id,
            'reason' => 'Test location',
            'description' => 'Test description',
        ]);
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/rentalsall');

        // Assertions
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'article_id',
                        'user_id',
                        'reason',
                        'description',
                        'exit_quantity',
                        'exit_date',
                        'entry_quantity',
                        'entry_date',
                        // Autres champs de la ressource RentalResource...
                    ],
                ],
                'links',
                'meta',
            ]);
    }
    public function test_can_create_rental()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $articleMovement = factory(ArticleMovement::class)->create(['stock' => 15]);
        $article = $articleMovement->article;

        $user = factory(User::class)->create();



        $data = [
            'user_id'        => $user->id,
            'article_id'     => $article->id,
            'description'    => 'Test de location',
            'reason'         => 'Projet spécial',
            'exit_quantity'  => 5,
            'exit_date'      => now()->toDateString(),
            'exit_condition' => 'Bon état',
            'entry_quantity' => 2,
            'entry_date'     => now()->addDays(3)->toDateString(),
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/rentals', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => __('budget.create.success'),
                'data' => [
                    'article_id' => $data['article_id'],
                    'user_id' => $data['user_id'],
                    'exit_quantity' => $data['exit_quantity'],
                    'entry_quantity' => $data['entry_quantity'],
                ]
            ]);

        $this->assertDatabaseHas('rentals', [
            'article_id' => $data['article_id'],
            'user_id' => $data['user_id'],
        ]);
    }

    public function test_can_show_rental()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $rental = factory(Rental::class)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->getJson("/api/rentals/{$rental->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $rental->id,
                    'article_id' => $rental->article_id,
                    'user_id' => $rental->user_id,
                ]
            ]);
    }

    public function test_can_update_rental()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $rental = factory(Rental::class)->create([
            'entry_quantity' => 1,
            'exit_quantity' => 5,
        ]);

        $updateData = [
            'description' => 'Mise à jour test',
            'return_quantity' => 2,
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->putJson("/api/rentals/{$rental->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => __('budget.update.success'),
                'data' => [
                    'description' => 'Mise à jour test',
                    'entry_quantity' => $rental->entry_quantity + 2,
                ]
            ]);

        $this->assertDatabaseHas('rentals', [
            'id' => $rental->id,
            'description' => 'Mise à jour test',
        ]);
    }

    public function test_can_archive_rental()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $rental = factory(Rental::class)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/rentals/trash', ['ids' => [$rental->id]]);

        $response->assertStatus(204);
        $this->assertSoftDeleted('rentals', ['id' => $rental->id]);
    }

    public function test_can_restore_rental()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $rental = factory(Rental::class)->create();
        $rental->delete();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/rentals/restore', ['ids' => [$rental->id]]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'success' => true,
                'message' => __('rental.restore.success'),
            ]);

        $this->assertDatabaseHas('rentals', ['id' => $rental->id, 'deleted_at' => null]);
    }

    public function test_can_delete_rental_permanently()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $rental = factory(Rental::class)->create();
        $rental->delete();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/rentals/delete', ['ids' => [$rental->id]]);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('rentals', ['id' => $rental->id]);
    }

}
