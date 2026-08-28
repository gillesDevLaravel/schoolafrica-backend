<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SMSTest extends TestCase
{
    use WithFaker;

//    public function testCanSendSMS()
//    {
//        $login = parent::login([
//            'username' => 'parentdev',
//            'password' => '000000'
//        ]);
//
//        $totalUsers = User::count();
//        $count = min(1, 3);
//
//        // Récupère les utilisateurs aléatoires
//        $randomUsers = User::inRandomOrder()->limit($count)
//            ->pluck('id')
//            ->toArray();
//
//        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
//            ->postJson("/api/sms", [
//                'idUsers' => $randomUsers,
//                'message' => $this->faker->text,
//            ])
//            ->assertStatus(200)
//            ->assertJsonStructure([
//                'responsecode'
//            ]);
//    }

    public function testFounderCanGetSMSBalance()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->get("/api/sms/balance")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data', 'success', 'message'
            ]);
    }

    public function testParentCannotGetSMSBalance()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->get("/api/sms/balance")
            ->assertStatus(403);
    }
}
