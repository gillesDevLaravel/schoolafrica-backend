<?php

namespace Tests\Unit\Documents\BulletinPrimaire;

use Tests\TestCase;

class BulletinPrimaireSequenceTest extends TestCase
{
//    public function testCanGenerateBulletinFromNewStructure()
//    {
//        $login = parent::login([
//            'username' => 'fondateur',
//            'password' => '000000'
//        ]);
//
//        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
//            ->postJson('/api/generer-bulletin-primaire-trimestre-new', [
//                'idClasse' => 10,
//                'idAssessmentType' => 1,
//                "route" => "lacledusavoir"
//            ]);
//        dd($response->getContent());
////            ->assertStatus(200);
//
//        // On vérifie que le fichier PDF est bien généré
//        $this->assertMatchesRegularExpression(
//            '/^https?:\/\/.+\.(zip)$/',
//            $response->json('data')
//        );
//    }

//    public function testCanGenerateBulletinPrimaireSequence()
//    {
//        $login = parent::login([
//            'username' => 'fondateur',
//            'password' => '000000'
//        ]);
//
//        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
//            ->postJson('/api/generer-bulletin-primaire-sequence', [
//                'idClasse' => 10,
//                'idAssessmentType' => 2,
//                "route" => "juniors"
//            ])
//            ->assertStatus(200);
//
//        // On vérifie que le fichier PDF est bien généré
//        $this->assertMatchesRegularExpression(
//            '/^https?:\/\/.+\.(zip)$/',
//            $response->json('data')
//        );
//    }
//
//    public function testCanGenerateBulletinPrimaireSequenceForSpecificUser()
//    {
//        $login = parent::login([
//            'username' => 'fondateur',
//            'password' => '000000'
//        ]);
//
//        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
//            ->postJson('/api/generer-bulletin-primaire-sequence', [
//                'idClasse' => 10,
//                'idAssessmentType' => 2,
//                "route" => "juniors",
//                'idUser' => 891
//            ]);
//
//        dd($response->getContent());
////            ->assertStatus(200);
//
//        // On vérifie que le fichier PDF est bien généré
//        $this->assertMatchesRegularExpression(
//            '/^https?:\/\/.+\.(pdf)$/',
//            $response->json('data')
//        );
//    }
//
//    public function testCannoGenerateBulletinPrimaireSequenceForInsolvableUser()
//    {
//        $login = parent::login([
//            'username' => 'parentdev',
//            'password' => '000000'
//        ]);
//
//        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
//            ->postJson('/api/generer-bulletin-primaire-sequence', [
//                'idClasse' => 10,
//                'idAssessmentType' => 2,
//                "route" => "juniors",
//                'idUser' => 17
//            ])
//            ->assertStatus(404)
//            ->assertJsonStructure([
//                'success', 'message'
//            ]);
//    }
}
