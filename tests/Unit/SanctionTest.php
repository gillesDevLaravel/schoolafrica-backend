<?php

namespace Tests\Unit;

use App\Models\Sanction;
use App\Models\User;
use Tests\TestCase;

class SanctionTest extends TestCase
{
    public function test_can_get_sanctions()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/sanctionsall')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }
    public function test_can_filter_sanctions_by_class_and_date()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        // Suppose qu'il existe une classe avec l'id 1 et une date spécifique
        $idClasse = 1;
        $date = '2024-07-03';
        $dateStart = '2024-07-01';
        $dateEnd = '2024-07-31';

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/sanctionsall', [
                'idClasse' => $idClasse,
                'date' => $date,
                'date_start' => $dateStart,
                'date_end' => $dateEnd,
            ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

    }

    public function test_can_create_sanction()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/sanctions', [
                'type' => 'Sanction',
                'typeUser' => "staff",
                'description' => 'Sanction description',
                'reasons' => "akieuh",
                'idUser' => User::inRandomOrder()->first()->id,
            ]);

//        dd($response->getStatusCode());

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_update_sanction()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $sanction = Sanction::create([
            'type' => 'Sanction',
            'typeUser' => "staff",
            'description' => 'Sanction description',
            'reasons' => "akieuh",
            'idUser' => User::inRandomOrder()->first()->id,
            'idSchool' => 2,
            'idSection' => 2,
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/sanctions/{$sanction->id}", [
                'type' => 'Sanction',
                'typeUser' => "staff",
                'description' => 'Sanction description',
                'reasons' => "akieuh",
                'idUser' => User::inRandomOrder()->first()->id,
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        $sanction->delete();
    }

    public function test_can_delete_sanction()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $sanction = Sanction::create([
            'type' => 'Sanction',
            'typeUser' => "staff",
            'description' => 'Sanction description',
            'reasons' => "akieuh",
            'idUser' => User::inRandomOrder()->first()->id,
            'idSchool' => 2,
            'idSection' => 2,
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->delete("/api/sanctions/{$sanction->id}")
            ->assertStatus(200);
    }
}
