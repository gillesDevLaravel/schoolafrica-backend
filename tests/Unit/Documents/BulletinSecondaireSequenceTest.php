<?php

namespace Tests\Unit\Documents;

use Tests\TestCase;

class BulletinSecondaireSequenceTest extends TestCase
{
    public function testCannotGenerateBulletinSecondaireSequenceWithMissingParameters()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/generer-bulletin-secondaire-sequence', [
                'idClasse' => 56,
//                'idAssessmentType' => 18
            ])
            ->assertStatus(422);
    }

    public function testCanGenerateBulletinSecondaireSequenceForClasse()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/generer-bulletin-secondaire-sequence', [
                'idClasse' => 56,
                'idAssessmentType' => 18
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'success',
                'message',
            ]);

        // On vérifie que le fichier ZIP est bien généré
        $this->assertMatchesRegularExpression(
            '/^https?:\/\/.+\.(zip|pdf)$/',
            $response->json('data')
        );
    }

    public function testCanGenerateBulletinSecondaireSequenceForStudent()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/generer-bulletin-secondaire-sequence', [
                'idClasse' => 56,
                'idAssessmentType' => 18,
                'idUser' => 1089
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'success',
                'message',
            ]);

        // On vérifie que le fichier PDF est bien généré
        $this->assertMatchesRegularExpression(
            '/^https?:\/\/.+\.(pdf)$/',
            $response->json('data')
        );
    }
}
