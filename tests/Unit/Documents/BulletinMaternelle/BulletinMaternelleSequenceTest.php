<?php

namespace Tests\Unit\Documents\BulletinMaternelle;

use Tests\TestCase;

class BulletinMaternelleSequenceTest extends TestCase
{
//    public function testCanGenerateBulletinMaternelleSequence()
//    {
//        $login = parent::login([
//            'username' => 'fondateur',
//            'password' => '000000'
//        ]);
//
//        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
//            ->postJson('/api/generer-bulletin-maternelle-sequence', [
//                'idClasse' => 19,
//                'idAssessmentType' => 9
//            ])
//            ->assertStatus(200);
//
//        // On vérifie que le fichier PDF est bien généré
//        $this->assertMatchesRegularExpression(
//            '/^https?:\/\/.+\.(zip|pdf)$/',
//            $response->json('data')
//        );
//    }
//
//    public function testCanGenerateBulletinMaternelleSequenceForSpecificUser()
//    {
//        $login = parent::login([
//            'username' => 'fondateur',
//            'password' => '000000'
//        ]);
//
//        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
//            ->postJson('/api/generer-bulletin-maternelle-sequence', [
//                'idClasse' => 19,
//                'idAssessmentType' => 9,
//                'idUser' => 17
//            ])
//            ->assertStatus(200);
//
//        // On vérifie que le fichier PDF est bien généré
//        $this->assertMatchesRegularExpression(
//            '/^https?:\/\/.+\.(pdf|zip)$/', // TODO: on permet ça pour le moment vu qu'on n'est pas sur que ce user est solvable pour éviter le zip vide
//            $response->json('data')
//        );
//    }
//
//    public function testCannoGenerateBulletinmaternelleSequenceForInsolvableUser()
//    {
//        $login = parent::login([
//            'username' => 'parentdev',
//            'password' => '000000'
//        ]);
//
//
//        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
//            ->postJson('/api/generer-bulletin-maternelle-sequence', [
//                'idClasse' => 19,
//                'idAssessmentType' => 9,
//                'idUser' => 17
//            ])
//            ->assertStatus(404)
//            ->assertJsonStructure([
//                'success', 'message'
//            ]);
//    }
}
