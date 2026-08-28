<?php

namespace Tests\Unit\Documents;

use Tests\TestCase;

class UsersListWithMonthlyAssessmentsTest extends TestCase
{
    public function testCannotGenerateUsersListWithMonthlyAssessmentsWithMissingParameters()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/documents/pv-primaire-sequence', [
                'idClasse' => 56,
//                'idAssessmentType' => 18
            ])
            ->assertStatus(422)
            ->assertJsonStructure([
                'success',
                'message',
            ]);
    }

    public function testCanGenerateUsersListWithMonthlyAssessments()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/documents/pv-primaire-sequence', [
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
            '/^https?:\/\/.+\.(pdf)$/',
            $response->json('data')
        );
    }
}
