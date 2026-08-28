<?php

namespace Tests\Unit;

use App\Enums\MoratoriumStatusEnum;
use App\Enums\StatusEnum;
use App\Models\Moratorium;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class MoratoriumTest extends TestCase
{
    use WithFaker;
    public function testCanGetAllMoratorium(){
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000',
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->post("/api/moratoriumsall");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    "id",
                    'startDate',
                    'endDate',
                    'reason',
                    'status',
                    "created_at",
                    "updated_at",
                    "user",
                    "author",
                    "userApprove"
                ],
            ],
            'links',
            'meta',
        ]);
    }

    public function testCanStoreMoratorium(){
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000',
        ]);

        // Création d'utilisateurs liés
        $user = User::inRandomOrder()->first();
        $approver = User::inRandomOrder()->first();

        // Données dynamiques
        $data = [
            'idUser' => $user->id,
            'startDate' => Carbon::now()->toDateString(),
            'endDate' => Carbon::now()->addDays(rand(5, 15))->toDateString(),
            'reason' => Str::random(20), // Raison aléatoire
            'status' => $this->faker->randomElement(MoratoriumStatusEnum::values()), // Statut aléatoire depuis l'enum
            'idUserApprove' => $approver->id,
        ];

        // Envoi de la requête
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/moratoriums", $data);

        // Vérifications
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'startDate',
                'endDate',
                'reason',
                'status',
                'user',
                'author',
                'userApprove',
                'created_at',
                'updated_at',
            ]
        ]);

        // Vérification en BDD
        $this->assertDatabaseHas('moratoriums', [
            'idUser' => $data['idUser'],
            'reason' => $data['reason'],
            'status' => $data['status'],
        ]);
    }

    public function testApproveUserCanUpdateMoratorium(){
        // Connexion de l'utilisateur
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000',
        ]);

        $token = json_decode($login->getContent())->data->token;

        // Création d'utilisateurs liés
        $user = User::inRandomOrder()->first();

        $approverId = json_decode($login->getContent())->data->id;

        // Création d'un moratoire avec un statut 'PENDING_APPROVAL'
        $moratorium = Moratorium::create([
            'idUser' => $user->id,
            'startDate' => Carbon::now()->toDateString(),
            'endDate' => Carbon::now()->addDays(rand(5, 15))->toDateString(),
            'reason' => Str::random(20),
            'status' => MoratoriumStatusEnum::VALID, // Statut initial
            'idUserApprove' => $approverId, // Utilisateur à approuver
            'createdBy' => $user->id, // Utilisateur ayant créé
        ]);

        // Données pour la mise à jour du moratoire
        $data = [
            'status' => StatusEnum::APPROVED, // Mise à jour vers "APPROVED"
            'idUserApprove' => $approverId, // Assurer que l'approbateur est bien celui de la demande
        ];

        // Envoi de la requête de mise à jour
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->putJson("/api/moratoriums/{$moratorium->id}", $data);

        // Vérifications
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'startDate',
                'endDate',
                'reason',
                'status',
                'user',
                'author',
                'userApprove',
                'created_at',
                'updated_at',
            ]
        ]);

        // Vérification en base de données : s'assurer que le statut est bien mis à jour
        $this->assertDatabaseHas('moratoriums', [
            'id' => $moratorium->id,
            'status' => MoratoriumStatusEnum::APPROVED,
        ]);
    }

}
