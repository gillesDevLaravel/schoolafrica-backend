<?php

namespace Tests\Unit;

use App\Models\Transport;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransportTest extends TestCase
{
    use WithFaker;

    public function test_can_list_transports_with_pagination()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        factory(Transport::class, 5)->create([
            'name' => 'School Bus',
            'description' => 'Daily transport service',
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/transportsall');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'remark',
                        'description',
                        'amount_month',
                        'amount_terms1',
                        'amount_terms2',
                        'amount_terms3',
                        'amount',
                    ],
                ],
                'links',
                'meta',
            ]);
    }

    public function test_can_create_transport()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $data = [
            'name' => $this->faker->word,
            'remark'    => $this->faker->optional()->sentence,
            'description' => $this->faker->sentence,
            'amount_month' => 150,
            'amount_terms1' => 200,
            'amount_terms2' => 200,
            'amount_terms3' => 200,
            'amount' => 600,
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/transports', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => __('transport.create.success'),
                'data' => [
                    'name' => $data['name'],
                    'remark' => $data['remark'],
                    'description' => $data['description'],
                ]
            ]);

        $this->assertDatabaseHas('transports', [
            'name' => $data['name'],
            'remark' => $data['remark'],
            'amount' => $data['amount'],
        ]);
    }

    public function test_can_show_transport()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $transport = factory(Transport::class)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->getJson("/api/transports/{$transport->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $transport->id,
                    'name' => $transport->name,
                    'remark' => $transport->remark,
                    'description' => $transport->description,
                ]
            ]);
    }

    public function test_can_update_transport()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $transport = factory(Transport::class)->create([
            'name' => 'Initial Bus',
        ]);

        $updateData = [
            'name' => 'Updated Bus',
            'remark'    => $this->faker->optional()->sentence,
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->putJson("/api/transports/{$transport->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => __('transport.update.success'),
                'data' => [
                    'name' => 'Updated Bus',
                    'remark' => $updateData['remark'],
                ]
            ]);

        $this->assertDatabaseHas('transports', [
            'id' => $transport->id,
            'name' => 'Updated Bus',
            'remark' => $updateData['remark'],
        ]);
    }

    public function test_can_archive_transport()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $transport = factory(Transport::class)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/transports/trash', ['ids' => [$transport->id]]);

        $response->assertStatus(204);
        $this->assertSoftDeleted('transports', ['id' => $transport->id]);
    }

    public function test_can_restore_transport()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $transport = factory(Transport::class)->create();
        $transport->delete();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/transports/restore', ['ids' => [$transport->id]]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'success' => true,
                'message' => __('transport.restore.success'),
            ]);

        $this->assertDatabaseHas('transports', [
            'id' => $transport->id,
            'deleted_at' => null,
        ]);
    }

    public function test_can_delete_transport_permanently()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $transport = factory(Transport::class)->create();
        $transport->delete();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/transports/delete', ['ids' => [$transport->id]]);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('transports', ['id' => $transport->id]);
    }
}
