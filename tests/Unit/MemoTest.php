<?php

namespace Tests\Unit;

use App\Models\Memo;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MemoTest extends TestCase
{
    use WithFaker;

    public function test_can_list_memos_with_filters_and_pagination()
    {
        $login = parent::login([
            'username' => 'dev',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        factory(Memo::class, 5)->create([
            'type' => 'Information',
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/memosall');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'type',
                        'description',
                        'date',
                        'image',
                        'created_at',
                        'updated_at',
                        'created_by',
                    ],
                ],
                'links',
                'meta',
            ]);
    }

    public function test_can_create_multiple_memos()
    {
        $login = parent::login([
            'username' => 'dev',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $data = [
            'memos' => [
                [
                    'name'        => $this->faker->sentence(3),
                    'type'        => 'Information',
                    'description' => $this->faker->sentence(5),
                    'date'        => $this->faker->date('Y-m-d'),
                    'image'        => $this->faker->optional()->imageUrl(),
                ],
                [
                    'name'        => $this->faker->sentence(3),
                    'type'        => 'Rappel',
                    'description' => $this->faker->sentence(5),
                    'date'        => $this->faker->date('Y-m-d'),
                    'image'        => null,
                ],
            ]
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/memos', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => __('memo.create.success'),
            ]);

        foreach ($data['memos'] as $memo) {
            $this->assertDatabaseHas('memos', [
                'name'   => $memo['name'],
                'type'   => $memo['type'],
                'date'   => $memo['date'],
            ]);
        }
    }

    public function test_can_show_memo()
    {
        $login = parent::login([
            'username' => 'dev',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(Memo::class)->create([
            'name'        => $this->faker->sentence(3),
            'type'        => 'Information',
            'description' => $this->faker->sentence(5),
            'date'        => $this->faker->date('Y-m-d'),
            'image'        => $this->faker->optional()->imageUrl(),
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->getJson("/api/memos/{$record->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id'          => $record->id,
                    'name'        => $record->name,
                    'type'        => $record->type,
                    'description' => $record->description,
                    'date'        => $record->date->toISOString(),
                    'image'        => $record->image,
                    'created_at'  => $record->created_at->toISOString(),
                    'updated_at'  => $record->updated_at->toISOString(),
                    'created_by'  => $record->created_by,
                ]
            ]);
    }

    public function test_can_update_memo()
    {
        $login = parent::login([
            'username' => 'dev',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(Memo::class)->create([
            'type' => 'Information',
        ]);

        $updateData = [
            'type'        => 'Rappel',
            'description' => $this->faker->sentence(5),
            'date'        => $this->faker->date('Y-m-d'),
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->putJson("/api/memos/{$record->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => __('memo.update.success'),
                'data' => [
                    'type'        => $updateData['type'],
                    'description' => $updateData['description'],
                    'date' => \Carbon\Carbon::parse($updateData['date'])->toISOString(),
                ]
            ]);

        $this->assertDatabaseHas('memos', [
            'id' => $record->id,
            'type' => $updateData['type'],
        ]);
    }

    public function test_can_archive_memo()
    {
        $login = parent::login([
            'username' => 'dev',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(Memo::class)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/memos/trash', ['ids' => [$record->id]]);

        $response->assertStatus(204);
        $this->assertSoftDeleted('memos', ['id' => $record->id]);
    }

    public function test_can_restore_memo()
    {
        $login = parent::login([
            'username' => 'dev',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(Memo::class)->create();
        $record->delete();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/memos/restore', ['ids' => [$record->id]]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'success' => true,
                'message' => __('memo.restore.success'),
            ]);

        $this->assertDatabaseHas('memos', ['id' => $record->id, 'deleted_at' => null]);
    }

    public function test_can_delete_memo_permanently()
    {
        $login = parent::login([
            'username' => 'dev',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(Memo::class)->create();
        $record->delete();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/memos/delete', ['ids' => [$record->id]]);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('memos', ['id' => $record->id]);
    }
}
