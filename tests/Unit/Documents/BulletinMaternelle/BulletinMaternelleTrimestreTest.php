<?php

namespace Tests\Unit\Documents\BulletinMaternelle;

use Tests\TestCase;

class BulletinMaternelleTrimestreTest extends TestCase
{
//    public function testCanGenerateBulletinMaternelleTrimestre()
//    {
//        $login = parent::login([
//            'username' => 'fondateur',
//            'password' => '000000'
//        ]);
//
//        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
//            ->postJson('/api/generer-bulletin-maternelle-trimestre', [
//                'idClasse' => 19,
//                'idTrimestre' => 7,
//                "route" => "juniors"
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
//    public function testCanGenerateBulletinMaternelleClassiqueTrimestre()
//    {
//        $login = parent::login([
//            'username' => 'fondateur',
//            'password' => '000000'
//        ]);
//
//        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
//            ->postJson('/api/generer-bulletin-maternelle-trimestre', [
//                'idClasse' => 19,
//                'idTrimestre' => 7,
//                "route" => "lesalouettes"
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
////    public function testCanGenerateBulletinMaternelleTrimestreForSpecificUser()
////    {
////        $login = parent::login([
////            'username' => 'fondateur',
////            'password' => '000000'
////        ]);
////
////        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
////            ->postJson('/api/generer-bulletin-maternelle-trimestre', [
////                'idClasse' => 19,
////                'idTrimestre' => 7,
////                "route" => "juniors",
////                'idUser' => 17
////            ])
////            ->assertStatus(200);
////
////        // On vérifie que le fichier PDF est bien généré
////        $this->assertMatchesRegularExpression(
////            '/^https?:\/\/.+\.(pdf)$/',
////            $response->json('data')
////        );
////    }
//
//    public function testCannoGenerateBulletinmaternelleTrimestreForInsolvableUser()
//    {
//        $login = parent::login([
//            'username' => 'parentdev',
//            'password' => '000000'
//        ]);
//
//        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
//            ->postJson('/api/generer-bulletin-maternelle-trimestre', [
//                'idClasse' => 19,
//                'idTrimestre' => 7,
//                "route" => "juniors",
//                'idUser' => 17
//            ])
//            ->assertStatus(404)
//            ->assertJsonStructure([
//                'success', 'message'
//            ]);
//    }
}
