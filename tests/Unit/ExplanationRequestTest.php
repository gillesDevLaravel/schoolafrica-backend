<?php

namespace Tests\Unit;

use App\Models\ExplanationRequest;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExplanationRequestTest extends TestCase
{
    use WithFaker;

    public function test_can_list_explanation_requests_with_filters_and_pagination()
    {
        $login = parent::login([
            'username' => 'dev',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        factory(ExplanationRequest::class, 5)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/explanation-requests-all');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'idUser',
                        'idResponsable',
                        'image',
                        'comments',
                        'created_at',
                        'updated_at',
                        'created_by',
                        
                    ]
                ],
        
            ]);
    }

    public function test_can_create_multiple_explanation_requests()
    {
        $login = parent::login([
            'username' => 'dev',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $data = [
            'explanation_requests' => [
                [
                    'name' => $this->faker->name,
                    'description' => $this->faker->sentence,
                    'idUser' => 1,
                    'idResponsable' => 2,
                    'image' => $this->faker->optional()->imageUrl(),
                    'comments' => $this->faker->optional()->sentence,
                ],
                [
                    'name' => $this->faker->name,
                    'description' => $this->faker->sentence,
                    'idUser' => 3,
                    'idResponsable' => 4,
                    'image' => $this->faker->optional()->imageUrl(),
                    'comments' => $this->faker->optional()->sentence,
                ]
            ]
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/explanation-requests', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => __('explanation_request.create.success'),
            ]);

        foreach ($data['explanation_requests'] as $explanationRequest) {
            $this->assertDatabaseHas('explanation_requests', [
                'name' => $explanationRequest['name'],
                'description' => $explanationRequest['description'],
                'idUser' => $explanationRequest['idUser'],
                'idResponsable' => $explanationRequest['idResponsable'],
            ]);
        }
    }

    public function test_can_show_explanation_request()
    {
        $login = parent::login([
            'username' => 'dev',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(ExplanationRequest::class)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->getJson("/api/explanation-requests/{$record->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $record->id,
                    'name' => $record->name,
                    'description' => $record->description,
                    'idUser' => [
                        'id' => $record->idUser,
                    ],
                    'idResponsable' => [
                        'id' => $record->idResponsable,
                    ],
                    'image' => $record->image,
                    'comments' => $record->comments,
                ]
            ]);
    }

    public function test_can_update_explanation_request()
    {
        $login = parent::login([
            'username' => 'dev',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(ExplanationRequest::class)->create();

        $updateData = [
            'description' => 'Description mise à jour',
            'comments' => 'Commentaires ajoutés',
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->putJson("/api/explanation-requests/{$record->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => __('explanation_request.update.success'),
                'data' => [
                    'description' => $updateData['description'],
                    'comments' => $updateData['comments'],
                ]
            ]);

        $this->assertDatabaseHas('explanation_requests', [
            'id' => $record->id,
            'description' => 'Description mise à jour',
        ]);
    }

    public function test_can_archive_explanation_request()
    {
        $login = parent::login([
            'username' => 'dev',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(ExplanationRequest::class)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/explanation-requests/trash', ['ids' => [$record->id]]);

        $response->assertStatus(204);
        $this->assertSoftDeleted('explanation_requests', ['id' => $record->id]);
    }

    public function test_can_restore_explanation_request()
    {
        $login = parent::login([
            'username' => 'dev',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(ExplanationRequest::class)->create();
        $record->delete();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/explanation-requests/restore', ['ids' => [$record->id]]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'success' => true,
                'message' => __('explanation_request.restore.success'),
            ]);

        $this->assertDatabaseHas('explanation_requests', ['id' => $record->id, 'deleted_at' => null]);
    }

    public function test_can_delete_explanation_request_permanently()
    {
        $login = parent::login([
            'username' => 'dev',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(ExplanationRequest::class)->create();
        $record->delete();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/explanation-requests/delete', ['ids' => [$record->id]]);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('explanation_requests', ['id' => $record->id]);
    }
}
