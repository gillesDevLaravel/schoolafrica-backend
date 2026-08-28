<?php

namespace Tests\Unit;

use App\Models\Suggestion;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SuggestionTest extends TestCase
{
    use WithFaker;

    public function test_can_list_suggestions_with_filters_and_pagination()
    {
        // Connexion avec un utilisateur autorisé
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        // Préparation des données
        $user = factory(User::class)->create();

        factory(Suggestion::class, 5)->create([
            'user_id' => $user->id,
            'name' => 'Test rapport',
            'description' => 'Test description',
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/suggestionsall');

        // Assertions
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'user',
                        'name',
                        'description',
                    ],
                ],
                'links',
                'meta',
            ]);
    }

    public function test_can_create_suggestion()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $user = factory(User::class)->create();

        $data = [
            'user_id'         => $user->id,
            'isAnonymous'         => true,
            'name' => $this->faker->name,
            'description'     => $this->faker->sentence,
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/suggestions', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => __('suggestion.create.success'),
                'data' => [
                    'user' => $data['isAnonymous'] ? null : ['id' => $data['user_id']],
                    'name'    => $data['name'],
                    'description' => $data['description'],
                ]
            ]);

        $this->assertDatabaseHas('suggestions', [
            'user_id' => $data['user_id'],
            'name'    => $data['name'],
        ]);
    }

    public function test_can_show_suggestion()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $suggestion = factory(Suggestion::class)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->getJson("/api/suggestions/{$suggestion->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $suggestion->id,
                    'user' => $suggestion->is_anonymous ? null : ['id' => $suggestion->user_id],
                    'name' => $suggestion->name,
                    'description' => $suggestion->description,
                ]
            ]);
    }

    public function test_can_update_suggestion()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $suggestion = factory(Suggestion::class)->create([
            'user_id' => json_decode($login->getContent())->data->id,
            'name' => 'Rapport initial',
        ]);

        $updateData = [
            'name' => 'Rapport mis à jour',
            'isAnonymous'         => $this->faker->boolean,
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->putJson("/api/suggestions/{$suggestion->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => __('suggestion.update.success'),
                'data' => [
                    'name' => 'Rapport mis à jour',
                    'user' => $updateData['isAnonymous'] ? null : ['id' => $suggestion['user_id']],
                ]
            ]);

        $this->assertDatabaseHas('suggestions', [
            'id' => $suggestion->id,
            'name' => 'Rapport mis à jour',
            'is_anonymous' => $updateData['isAnonymous'],
        ]);
    }


    public function test_can_archive_suggestion()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $report = factory(Suggestion::class)->create([
            'user_id' => json_decode($login->getContent())->data->id,
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/suggestions/trash', ['ids' => [$report->id]]);

        $response->assertStatus(204);
        $this->assertSoftDeleted('suggestions', ['id' => $report->id]);
    }

    public function test_can_restore_suggestion()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $report = factory(Suggestion::class)->create();
        $report->delete();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/suggestions/restore', ['ids' => [$report->id]]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'success' => true,
                'message' => __('suggestion.restore.success'),
            ]);

        $this->assertDatabaseHas('suggestions', ['id' => $report->id, 'deleted_at' => null]);
    }

    public function test_can_delete_suggestion_permanently()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $report = factory(Suggestion::class)->create([
            'user_id' => json_decode($login->getContent())->data->id,
        ]);
        $report->delete();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/suggestions/delete', ['ids' => [$report->id]]);

        $this->assertDatabaseMissing('suggestions', ['id' => $report->id]);
    }
}
