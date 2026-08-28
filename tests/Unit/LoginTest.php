<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testUserCanLogin()
    {
        $user = [
            'username' => 'parentdev',
            'password' => '000000'
        ];
        $login = parent::login($user);

        $login->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function testUserWithFalseCredentialsCannotLogin()
    {

        $user = [
            'username' => 'parentdev',
            'password' => '00000'
        ];
        $login = parent::login($user);

        $login->assertStatus(404)
            ->assertJsonStructure(['message']);

    }

    public function test_user_can_get_his_informations()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->get('/api/user')
//        ->postJson('/api/requetes/', [
//            'libelle' => "Test requête TEST",
//            'description' => "Test req TEST",
//            'type' => "test_type"
//        ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'=> [
                    'id',
                    'name',
                    'phone',
                    'role',
                    'permissions',
                    'typeRole',
                    'adresse',
                    'photo',
                    'scholar_level',
                    'idCycle',
                    'idLevel',
                    'idSchool',
                    'idSection',
                    'classes',
                    'idBourse',
                    'isBourseUsed',
                    'build_number',
                    'build_number_verified',
                ],
            ]);
    }
}
