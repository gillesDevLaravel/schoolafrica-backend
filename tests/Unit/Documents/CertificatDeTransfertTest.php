<?php

namespace Tests\Unit\Documents;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CertificatDeTransfertTest extends TestCase
{
    use WithFaker;

    public function testCanGetListTransferts()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/transfertsall')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
            ]);
    }

    public function testCanGenerateCertificatDeTransfertForStudent()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/documents/certificat-transfert', [
                'idStudent' => 22,
                'route' => "juniors",
                'country' => $this->faker->country,
                'date' => $this->faker->date,
                'academic_year' => "2024 - 2025",
                'reason' => $this->faker->text(120),
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'success',
                'message',
            ]);

        // On vérifie que le fichier ZIP est bien généré
        $this->assertMatchesRegularExpression(
            '/^https?:\/\/.+\.(pdf)$/',
            $response->json('data')
        );
    }

    public function testCannotGenerateCertificatDeTransfertForStudentWithMissingRoute()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/documents/certificat-transfert', [
                'idStudent' => 22,
//                'route' => "juniors",
                'country' => $this->faker->country,
            ])
            ->assertStatus(422);
    }

    public function testCannotGenerateCertificatDeTransfertForStudentWithMissingCountry()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/documents/certificat-transfert', [
                'idStudent' => 22,
                'route' => "juniors",
//                'country' => $this->faker->country,
            ])
            ->assertStatus(422);
    }

    public function testCannotGenerateCertificatDeTransfertForStudentWithMissingReason()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/documents/certificat-transfert', [
                'idStudent' => 22,
                'route' => "juniors",
                'country' => $this->faker->country,
//                'reason' => $this->faker->text,
            ])
            ->assertStatus(422);
    }

    public function testCannotGenerateCertificatDeTransfertForUnexistingStudent()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/documents/certificat-transfert', [
                'idStudent' => 9797979797,
                'route' => "juniors",
                'country' => $this->faker->country,
            ])
            ->assertStatus(422);
    }
}
