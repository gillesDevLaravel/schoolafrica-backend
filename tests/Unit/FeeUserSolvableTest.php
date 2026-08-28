<?php

namespace Tests\Unit;

use Tests\TestCase;

class FeeUserSolvableTest extends TestCase
{
    public function testCanGetSolvablesForFeeUser()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/feeusers-solvables', [
                "idSchool" => 2,
                "idClasse" => 6,
                "idFee" => 1
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
            ]);
    }

    public function testCannotGetSolvablesForFeeUserWithMissingParam()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/feeusers-solvables', [
                "idSchool" => 2
            ])
            ->assertStatus(422)
            ->assertJsonStructure([
                'success',
                'message',
            ]);
    }

    public function testCanGetInsolvablesForFeeUser()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/feeusers-insolvables', [
                "idSchool" => 2,
                "idClasse" => 6,
                "idFee" => 1
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
            ]);
    }

    public function testCannotGetInsolvablesForFeeUserWithMissingParam()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/feeusers-insolvables', [
                "idSchool" => 2
            ])
            ->assertStatus(422)
            ->assertJsonStructure([
                'success',
                'message',
            ]);
    }
}
