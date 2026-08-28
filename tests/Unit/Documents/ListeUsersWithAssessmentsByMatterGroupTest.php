<?php

namespace Tests\Unit\Documents;

use Tests\TestCase;

class ListeUsersWithAssessmentsByMatterGroupTest extends TestCase
{
    public function testCannotGenerateListUsersWithAssessmentsByMatterGroupWithMissingParameters()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/documents/list-users-assessments-by-matter-group', [
                'idClasse' => 56,
                'idAssessmentType' => 18
            ])
            ->assertStatus(422)
            ->assertJsonStructure([
                'success',
                'message',
            ]);
    }

    public function testCanGenerateListUsersWithAssessmentsByMatterGroup()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/documents/list-users-assessments-by-matter-group', [
                'idClasse' => 10,
                'idTrimestre' => 1,
                'idMatterGroup' => 3
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
