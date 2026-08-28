<?php

namespace Tests\Unit;

use App\Models\TransportUser;
use App\Models\Transport;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransportUserTest extends TestCase
{
    use WithFaker;

    public function test_can_list_transport_users_with_filters_and_pagination()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $student = factory(User::class)->create();
        $transport = factory(Transport::class)->create();

        factory(TransportUser::class, 5)->create([
            'student_id' => $student->id,
            'transport_id' => $transport->id,
            'type' => 'monthly',
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/transport-usersall');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'student',
                        'transport',
                        'type',
                        'amount',
                        'reduction',
                        'reduction_amount',
                        'reason',
                    ],
                ],
                'links',
                'meta',
            ]);
    }

    public function test_can_create_transport_user()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $student = factory(User::class)->create();
        $transport = factory(Transport::class)->create();

        $data = [
            'student_id'   => $student->id,
            'transport_id' => $transport->id,
            'type'         => 'termly',
            'amount'         => $this->faker->randomFloat(2, 200, 1000),
            'reduction'         => $this->faker->randomElement([true, false]),
            'reduction_amount'         => $this->faker->randomFloat(2, 200, 1000),
            'reason'         => $this->faker->optional()->sentence
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/transport-users', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => __('transportUser.create.success'),
                'data' => [
                    'student' => ['id' => $data['student_id']],
                    'transport' => ['id' => $data['transport_id']],
                    'type' => $data['type'],
                    'amount' => $data['amount'],
                    'reduction' => $data['reduction'],
                    'reduction_amount' => $data['reduction_amount'],
                    'reason' => $data['reason'],
                ]
            ]);

        $this->assertDatabaseHas('transport_users', $data);
    }

    public function test_can_show_transport_user()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(TransportUser::class)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->getJson("/api/transport-users/{$record->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $record->id,
                    'student' => ['id' => $record->student_id],
                    'transport' => ['id' => $record->transport_id],
                    'type' => $record->type,
                    'amount' => $record->amount,
                    'reduction' => $record->reduction,
                    'reduction_amount' => $record->reduction_amount,
                    'reason' => $record->reason,
                ]
            ]);
    }

    public function test_can_update_transport_user()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(TransportUser::class)->create([
            'type' => 'monthly',
        ]);

        $updateData = [
            'type' => 'yearly',
            'amount'         => $this->faker->randomFloat(2, 200, 1000),
            'reduction'         => $this->faker->randomElement([true, false]),
            'reduction_amount'         => $this->faker->randomFloat(2, 200, 1000),
            'reason'         => $this->faker->optional()->sentence
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->putJson("/api/transport-users/{$record->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => __('transportUser.update.success'),
                'data' => [
                    'type' => 'yearly',
                    'amount' => $updateData['amount'],
                    'reduction' => $updateData['reduction'],
                    'reduction_amount' => $updateData['reduction_amount'],
                    'reason' => $updateData['reason'],
                ]
            ]);

        $this->assertDatabaseHas('transport_users', [
            'id' => $record->id,
            'type' => 'yearly',
        ]);
    }

    public function test_can_archive_transport_user()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(TransportUser::class)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/transport-users/trash', ['ids' => [$record->id]]);

        $response->assertStatus(204);
        $this->assertSoftDeleted('transport_users', ['id' => $record->id]);
    }

    public function test_can_restore_transport_user()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(TransportUser::class)->create();
        $record->delete();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/transport-users/restore', ['ids' => [$record->id]]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'success' => true,
                'message' => __('transportUser.restore.success'),
            ]);

        $this->assertDatabaseHas('transport_users', ['id' => $record->id, 'deleted_at' => null]);
    }

    public function test_can_delete_transport_user_permanently()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(TransportUser::class)->create();
        $record->delete();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/transport-users/delete', ['ids' => [$record->id]]);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('transport_users', ['id' => $record->id]);
    }
}
