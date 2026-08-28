<?php

namespace Tests\Unit\Documents\BulletinPrimaire;

use Tests\TestCase;

class BulletinPrimaireTrimestreTest extends TestCase
{
//    public function testCanGenerateBulletinFromNewStructure()
//    {
//        $login = parent::login([
//            'username' => 'fondateur',
//            'password' => '000000'
//        ]);
//
//        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
//            ->postJson('/api/generer-bulletin-primaire', [
//                'idClasse' => 10,
//                'idTrimestre' => 1,
//                "route" => "lesalouettes"
//            ]);
////        dd($response->getContent());
////            ->assertStatus(200);
//
//        // On vérifie que le fichier PDF est bien généré
//        $this->assertMatchesRegularExpression(
//            '/^https?:\/\/.+\.(zip)$/',
//            $response->json('data')
//        );
//    }
//    public function testCanGenerateBulletinForOneStudentFromNewStructure()
//    {
//        $login = parent::login([
//            'username' => 'fondateur',
//            'password' => '000000'
//        ]);
//
//        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
//            ->postJson('/api/generer-bulletin-primaire', [
//                'idClasse' => 10,
//                'idTrimestre' => 1,
//                "idUser" => 897,
//                "route" => "cfa"
//            ])
//            ->assertStatus(200);
//
//        // On vérifie que le fichier PDF est bien généré
//        $this->assertMatchesRegularExpression(
//            '/^https?:\/\/.+\.(pdf)$/',
//            $response->json('data')
//        );
//    }

    public function testCannotGenerateBulletinForOneStudentFromNewStructureWithMissingParameter()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/generer-bulletin-primaire-trimestre-new', [
//                'idClasse' => 10,
                "idUser" => 897,
                "route" => "cfa"
            ])
            ->assertStatus(422);
    }
}
