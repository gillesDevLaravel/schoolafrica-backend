<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeviceTokenTest extends TestCase
{
    use WithFaker;

    public function testCanRegisterDeviceTokenForAccount()
    {
        $tmp_user = User::where('username', 'fondateur')->first();
        $tmp_user->device_key = null;
        $tmp_user->save();

        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $faker_uuid = $this->faker->uuid;

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/store-token', [
                'token' => $faker_uuid
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        $this->assertStringContainsString($faker_uuid, $tmp_user->refresh()->device_key);
    }

    /**
     * Puisqu'on peut stocker plusieurs clés dans un device_key, on s'assure qu'un compte spécifique contient un token spécifique
     *
     * @return void
     */
    public function testDeviceTokenForAccountContainsToken()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $user = json_decode($login->getContent())->data;

        $tmp_user = User::find($user->id);

        $faker_uuid = $this->faker->uuid;

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/store-token', [
                'token' => $faker_uuid
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        $this->assertStringContainsString($faker_uuid, $tmp_user->refresh()->device_key);
    }

//    public function testDeviceTokenForAccountDoesNoMoreContainsTokenAfterLogout()
//    public function test_device_token_for_account_does_no_more_contains_token_after_logout()
//    {
//        $login = parent::login([
//            'username' => 'fondateur',
//            'password' => '000000'
//        ]);
//
//        $user = User::find(json_decode($login->getContent())->data->id);
////        $token = $user->createToken('Token des Tests Unitaires')->accessToken;
//
//        $dev_keys = $user->splitDeviceKey();
//
//        // Early return if no device key
//        if (empty($dev_keys) || empty($dev_keys[0])) {
//            return; // rien à faire si il a pas de clé
//        }
//
//        $device_key_to_delete = $dev_keys[0]; // on va simplement récupérer la première clé
//
//        // Logout request with the device key
//        $r = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
//            ->postJson('/api/logout', [
//                'token' => $device_key_to_delete
//            ]);
////            ->assertStatus(200)
////            ->assertJsonStructure(['data']);
//
//        dd($r->getContent());
//
//        // Refresh user instance after logout
//        $user->refresh();
//
//        // Assert that the device key has been removed from the user's device_key
//        $this->assertFalse(str_contains($user->device_key, $device_key_to_delete), 'The device key was not removed.');
//    }
}
