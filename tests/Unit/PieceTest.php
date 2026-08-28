<?php

namespace Tests\Unit;

use App\Models\Piece;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PieceTest extends TestCase
{
    use WithFaker;

    public function test_can_list_pieces_with_filters_and_pagination()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        factory(Piece::class, 5)->create([
             'etage' => 'RDC',
            'status' => 'active',
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/piecesall');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'etage',
                        'description',
                        'status',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'links',
                'meta',
            ]);
    }

public function test_can_create_multiple_pieces()
{
    $login = parent::login([
        'username' => 'fondateur',
        'password' => '000000'
    ]);
    $token = json_decode($login->getContent())->data->token;

    $data = [
        'pieces' => [
            [
                'name'        => $this->faker->word,
                'etage'       => '1er',
                'description' => $this->faker->optional()->sentence,
                'status'      => 'active',
            ],
            [
                'name'        => $this->faker->word,
                'etage'       => '2ème',
                'description' => $this->faker->optional()->sentence,
                'status'      => 'inactive',
            ],
        ]
    ];

    $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
        ->postJson('/api/pieces', $data);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => __('piece.create.success'),
        ]);

    foreach ($data['pieces'] as $piece) {
        $this->assertDatabaseHas('pieces', [
            'name'   => $piece['name'],
            'etage'  => $piece['etage'],
            'status' => $piece['status'],
        ]);
    }
}



    public function test_can_show_piece()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(Piece::class)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->getJson("/api/pieces/{$record->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $record->id,
                    'name' => $record->name,
                    'etage' => $record->etage,
                    'description' => $record->description,
                    'status' => $record->status,
                ]
            ]);
    }

    public function test_can_update_piece()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(Piece::class)->create([
            'status' => 'active',
        ]);

        $updateData = [
            'status' => 'inactive',
            'description' => $this->faker->optional()->sentence,
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->putJson("/api/pieces/{$record->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => __('piece.update.success'),
                'data' => [
                    'status' => $updateData['status'],
                    'description' => $updateData['description'],
                ]
            ]);

        $this->assertDatabaseHas('pieces', [
            'id' => $record->id,
            'status' => 'inactive',
        ]);
    }

    public function test_can_archive_piece()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(Piece::class)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/pieces/trash', ['ids' => [$record->id]]);

        $response->assertStatus(204);
        $this->assertSoftDeleted('pieces', ['id' => $record->id]);
    }

    public function test_can_restore_piece()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(Piece::class)->create();
        $record->delete();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/pieces/restore', ['ids' => [$record->id]]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'success' => true,
                'message' => __('piece.restore.success'),
            ]);

        $this->assertDatabaseHas('pieces', ['id' => $record->id, 'deleted_at' => null]);
    }

    public function test_can_delete_piece_permanently()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(Piece::class)->create();
        $record->delete();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/pieces/delete', ['ids' => [$record->id]]);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('pieces', ['id' => $record->id]);
    }
}
