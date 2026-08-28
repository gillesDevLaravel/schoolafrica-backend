<?php

namespace Tests\Unit\Documents\PV;

use Tests\TestCase;

class PVSecondaireTest extends TestCase
{
    public function testCanGeneratePVSecondaire()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/documents/pv-secondaire', [
                'idClasse' => 56,
                'idAssessmentType' => 18,
                "route" => "dev",
                "sortUsers" => "merit"
            ])
            ->assertStatus(200);

        // On vérifie que le fichier PDF est bien généré
        $this->assertMatchesRegularExpression(
            '/^https?:\/\/.+\.(pdf)$/',
            $response->json('data')
        );
    }

    public function testCannotGeneratePVSecondaireWithMissingParam()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/documents/pv-secondaire', [
//                'idClasse' => 56,
                'idAssessmentType' => 18,
                "route" => "dev",
                "sortUsers" => "merit"
            ])
            ->assertStatus(422);
    }
}
