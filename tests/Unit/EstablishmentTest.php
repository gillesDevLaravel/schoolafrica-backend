<?php

namespace Tests\Unit;

use App\Models\Establishment;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EstablishmentTest extends TestCase
{
    use WithFaker;

    public function test_can_get_establishments()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/establishmentsall');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_create_establishment_with_cnps()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $establishmentData = [
            'name' => $this->faker->company . ' ' . time(),
            'ministry' => $this->faker->word,
            'region' => $this->faker->city,
            'department' => $this->faker->word,
            'phone' => $this->faker->phoneNumber,
            'mobile_money_number' => $this->faker->numerify('### ### ### ###'),
            'rib' => $this->faker->numerify('####################'),
            'cnps' => $this->faker->numerify('#########'), // CNPS number format
            'banque' => $this->faker->company,
            'om' => $this->faker->numerify('#########'),
            'country' => 'Cameroun',
            'email' => $this->faker->companyEmail,
            'idPackage' => 1,
            'pay_om_fees' => false,
            'idFounder' => null,
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/establishments', $establishmentData);

//        dd($response->getStatusCode() . $response->getContent());

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'cnps'
                ]
            ]);

        // Clean up
        $createdId = $response->getData()->data->id;
        if ($createdId) {
            Establishment::find($createdId)->delete();
        }
    }

    public function test_can_show_establishment_details()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $establishment = factory(Establishment::class)->create();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->getJson("/api/establishments/{$establishment->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'cnps'
                ]
            ]);

        $establishment->delete();
    }

    public function test_can_update_establishment_cnps()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $establishment = factory(Establishment::class)->create([
            'cnps' => null,
            'idPackage' => 1,
            'pay_om_fees' => false,
        ]);

        $updateData = [
            'cnps' => $this->faker->numerify('#########'),
            'idPackage' => 1,
            'pay_om_fees' => false,
            'name' => $establishment->name,
            'phone' => $establishment->phone,
            'country' => $establishment->country,
            'email' => $establishment->email,
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/establishments/{$establishment->id}", $updateData)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'cnps'
                ]
            ]);

        $establishment->delete();
    }

    public function test_can_delete_establishment()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $establishment = factory(Establishment::class)->create();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->deleteJson("/api/establishments/{$establishment->id}")
            ->assertStatus(200);
    }
}
