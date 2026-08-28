<?php

namespace Tests\Unit;

use App\Models\Client;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use WithFaker;

    public function testCanGetClients(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/clientsall', [
                'idSchool' => 2
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data', 'meta', 'links'
            ]);
    }

    public function testCanGetSingleClient(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $bo = Client::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->getJson("/api/clients/{$bo->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanCreateClient()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $clients = [
            [
                'name' => $this->faker->name,
                'amount' => rand(1000,9999),
                'adresse' => $this->faker->address,
                'type' => 'entreprise',
                'phone' => $this->faker->phoneNumber,
                'mobile' => $this->faker->phoneNumber,
                'email' => $this->faker->email,
            ],
            [
                'name' => $this->faker->name,
                'amount' => rand(1000,9999),
                'adresse' => $this->faker->address,
                'type' => 'personnel',
                'phone' => $this->faker->phoneNumber,
                'mobile' => $this->faker->phoneNumber,
                'email' => $this->faker->email,
            ],
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/clients', [
                'clients' => $clients
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanUpdateClient()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $bo = Client::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/clients/{$bo->id}", [
                'name' => $this->faker->name,
                'amount' => rand(1000,9999),
                'adresse' => $this->faker->address,
                'type' => 'personnel',
                'phone' => $this->faker->phoneNumber,
                'mobile' => $this->faker->phoneNumber,
                'email' => $this->faker->email,
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanTrashClient()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $bo = Client::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->deleteJson("/api/clients/trash/{$bo->id}")
            ->assertStatus(200);

        $bo->update([
            'updated_by' => auth()->user()->id,
            'deleted' => false
        ]);
    }

    public function testCanRestoreTrashedClient()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $bo = Client::latest()->first();
        $bo->update([
            'updated_by' => auth()->user()->id,
            'deleted' => true
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/clients/restore/{$bo->id}")
            ->assertStatus(200);
    }
}
