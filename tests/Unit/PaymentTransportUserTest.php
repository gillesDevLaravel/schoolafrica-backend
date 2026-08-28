<?php

namespace Tests\Unit;

use App\Models\PaymentTransportUser;
use App\Models\TransportUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentTransportUserTest extends TestCase
{
    use WithFaker;

    public function test_can_list_payment_transport_users_with_filters_and_pagination()
    {
        // Arrange : se connecter
        $login = $this->login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        // Créer les données nécessaires
        $user = factory(User::class)->create();
        $transportUser = factory(TransportUser::class)->create([
            'student_id' => $user->id,
            'amount' => 50000,
        ]);

        factory(PaymentTransportUser::class)->create([
            'transport_user_id' => $transportUser->id,
            'advance_payment'   => 20000,
            'balance_payment'   => 30000,
            'payment_mode'      => 'Cash',
            'solvable'          => 'avancé',
            'payment_date'      => Carbon::now()->subDay(),
            'telephone'         => '123456789',
            'reference'         => 'REF123',
            'created_by'        => $user->id,
        ]);

        factory(PaymentTransportUser::class)->create([
            'transport_user_id' => $transportUser->id,
            'advance_payment'   => 15000,
            'balance_payment'   => 15000,
            'payment_mode'      => 'Orange Money',
            'solvable'          => 'avancé',
            'payment_date'      => Carbon::now(),
            'telephone'         => '987654321',
            'reference'         => 'REF456',
            'created_by'        => $user->id,
        ]);

        // Act : appel API avec filtres
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->postJson('/api/payment-transport-usersall', [
            'transport_user_id' => $transportUser->id,
            'payment_mode'      => 'Cash',
            'date_start'        => Carbon::now()->subDays(2)->format('Y-m-d'),
            'date_end'          => Carbon::now()->addDay()->format('Y-m-d'),
            'pageItems'         => 1,
            'nbreItems'         => 1,
            'group_by'          => 'day',
            'filter_value'      => 'REF123',
        ]);

//        dd($response->getContent());

// Assert : structure JSON
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'transport_user' => [
                            'id',
                            'transport' => [
                                'id',
                                'name',
                                'amount',
                                'amount_terms1',
                                'amount_terms3',
                                'created_at',
                                'updated_at',
                            ],
                            'student' => [
                                'id',
                                'name',
                                'email',
                                'gender',
                                'created_at',
                                'updated_at',
                            ],
                            'type',
                            'amount',
                            'reduction',
                            'reduction_amount',
                            'reason',
                            'created_at',
                        ],
                        'advance_payment',
                        'balance_payment',
                        'payment_date',
                        'payment_mode',
                        'solvable',
                        'scan_receipt',
                        'photo',
                        'reason',
                        'receipt_number',
                        'telephone',
                        'reference',
                        'created_by' => [
                            'id',
                            'name',
                            'email',
                            'phone',
                        ],
                        'updated_by',
                        'deleted_by',
                    ],
                ],
                'meta' => [
                    'current_page',
                    'last_page',
                    'to',
                    'total',
                ],
                'sommes',
                'om',
                'momo',
                'cash',
                'bank',
            ])
            ->assertJson([
                'meta' => [
                    'current_page' => 1,
                    'last_page'    => 1,
                    'to'           => 1,
                    'total'        => 1,
                ],
            ]);

        // Vérifier que la base contient bien le paiement attendu
        $this->assertDatabaseHas('payment_transport_users', [
            'transport_user_id' => $transportUser->id,
            'payment_mode'      => 'Cash',
            'reference'         => 'REF123',
        ]);
    }

    public function test_can_create_payment_transport_user()
    {
        // Login as a user
        $login = $this->login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        // Create a user and transport user
        $user = factory(User::class)->create();
        $transportUser = factory(TransportUser::class)->create([
            'student_id' => $user->id,
            'amount' => 50000
        ]);

        // Prepare valid payment data
        $data = [
            'transport_user_id' => $transportUser->id,
            'advance_payment' => 20000,
            'payment_date' => now()->toDateString(),
            'payment_mode' => 'cash',
            'solvable' => 'avancé',
            'receipt_number' => 'REC123',
            'telephone' => '123456789',
            'reference' => 'REF123'
        ];

        // Make API request
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/payment-transport-users', $data);

        // Assert response
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => __('paymentTransportUser.create.success'),
            ]);

//        dd($response->getContent());

        // Assert database has payment record
        $this->assertDatabaseHas('payment_transport_users', [
            'transport_user_id' => $data['transport_user_id'],
            'advance_payment' => $data['advance_payment'],
//            'balance_payment' => $transportUser->price - $data['advance_payment'],
            'payment_mode' => $data['payment_mode'],
            'solvable' => $data['solvable'],
            'receipt_number' => $data['receipt_number'],
            'telephone' => $data['telephone'],
            'reference' => $data['reference']
        ]);

        // Assert notification was created
        $this->assertDatabaseHas('notifications', [
            'notificationable_type' => PaymentTransportUser::class,
            'notificationable_id' => PaymentTransportUser::latest()->first()->id,
            'grouped_users' => json_encode([$user->id, $user->idParent])
        ]);
    }
    public function test_can_show_payment_transport_user()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $payment = factory(PaymentTransportUser::class)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->getJson("/api/payment-transport-users/{$payment->id}");



        $response->assertStatus(200)
            ->assertJsonPath('data.id', $payment->id)
            ->assertJsonPath('data.transport_user.id', $payment->transport_user_id);

    }

    public function test_can_update_payment_transport_user()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $payment = factory(PaymentTransportUser::class)->create();

        $updateData = [
            'transport_user_id' => factory(TransportUser::class)->create()->id,
            'advance_payment'   => $this->faker->randomFloat(2, 0, 200),
            'balance_payment'   => $this->faker->randomFloat(2, 0, 800),
            'solvable'          => 'oui',
            'reason'            => $this->faker->sentence,
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->putJson("/api/payment-transport-users/{$payment->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'advance_payment' => $updateData['advance_payment'],
                'balance_payment' => $updateData['balance_payment'],
                'solvable'        => $updateData['solvable'],
            ]);

        $this->assertDatabaseHas('payment_transport_users', [
            'id'               => $payment->id,
            'transport_user_id'=> $updateData['transport_user_id'],
            'advance_payment'  => $updateData['advance_payment'],
            'balance_payment'  => $updateData['balance_payment'],
            'solvable'         => $updateData['solvable'],
        ]);
    }

    public function test_can_archive_payment_transport_user()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $payment = factory(PaymentTransportUser::class)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/payment-transport-users/trash', ['ids' => [$payment->id]]);

        $response->assertStatus(204);
        $this->assertSoftDeleted('payment_transport_users', ['id' => $payment->id]);
    }

    public function test_can_restore_payment_transport_user()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $payment = factory(PaymentTransportUser::class)->create();
        $payment->delete();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/payment-transport-users/restore', ['ids' => [$payment->id]]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'success' => true,
                'message' => __('paymentTransportUser.restore.success'),
            ]);

        $this->assertDatabaseHas('payment_transport_users', ['id' => $payment->id, 'deleted_at' => null]);
    }

    public function test_can_delete_payment_transport_user_permanently()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $payment = factory(PaymentTransportUser::class)->create();
        $payment->delete();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/payment-transport-users/delete', ['ids' => [$payment->id]]);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('payment_transport_users', ['id' => $payment->id]);
    }
}
