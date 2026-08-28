<?php

namespace Tests\Unit\Documents;

use Tests\TestCase;

class SolvablesAndInsolvablesTest extends TestCase
{
    public function testUserCanGenerateSolvablesListPDF()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $resp = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/documents/list-solvables', [
                'idSchool' => 2,
                'idSection' => 2,
                'idClasse' => 18
            ])
            ->assertJsonStructure([
                'success',
                'message'
            ]);

        if(json_decode($resp->getContent())->success){
            $resp->assertStatus(200)
                ->assertJsonStructure([
                    'data'
                ]);
        }else{
            $resp
                ->assertStatus(404);
        }
    }
    public function testUserCannnotGenerateSolvablesListPDFWithBadParams()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/documents/list-solvables', [
                'idSchool' => 2,
                'idSection' => 2,
                'idClasse' => 999
            ])
            ->assertStatus(404)
            ->assertJsonStructure([
                'success',
                'message',
            ]);
    }

    public function testUserCanGenerateInsolvablesListPDF()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $resp = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/documents/list-insolvables', [
                'idSchool' => 2,
                'idSection' => 2,
                'idClasse' => 18
            ])
            ->assertJsonStructure([
                'success',
                'message'
            ]);

        if(json_decode($resp->getContent())->success){
            $resp->assertStatus(200)
                ->assertJsonStructure([
                    'data'
                ]);
        }else{
            $resp
                ->assertStatus(404);
        }
    }

    public function testUserCannotGenerateInsolvablesListPDFWithBadParams()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $resp = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/documents/list-insolvables', [
                'idSchool' => 2,
                'idSection' => 2,
                "idClasse" => 999
            ])
            ->assertJsonStructure([
                'success',
                'message'
            ]);


        if(json_decode($resp->getContent())->success){
            $resp->assertStatus(200)
                ->assertJsonStructure([
                    'data'
                ]);
        }else{
            $resp
                ->assertStatus(404);
        }
    }
}
