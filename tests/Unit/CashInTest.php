<?php

namespace Tests\Unit;

use App\Models\CashIn;
use App\Models\Client;
use App\Models\TypeOfRecipe;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CashInTest extends TestCase
{
    use WithFaker;

    public function testCanGetCashIns(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/cashinsall', [
                'filter_value' => $this->faker->word
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data', 'meta', 'links'
            ]);
    }

    public function testCanGetSingleCashIn(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $cas = CashIn::latest()->first();

        if(is_null($cas)){
            return;
        }

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->getJson("/api/cashins/{$cas->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanCreateCashIn()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $params = [
            'idClient' => User::inRandomOrder()->first()->id,
            'amount_to_receive' => (string) rand(1000,99999),
            'amount_received' => (string) rand(1000,99999),
            'reason' => $this->faker->sentence(),
            'payment_method' => $this->faker->word(),
            'irpp' => $this->faker->boolean(),
            'payment_date' => $this->faker->date(),
            'receipt_number' => $this->faker->bothify('RCPT-####??'),
            'operator' => $this->faker->word(), // ou ->name() selon le contexte
            'idTypeOfRecipe' => factory(TypeOfRecipe::class)->create()->id,
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/cashins', $params)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanUpdateCashIn()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $bo = CashIn::inRandomOrder()->first();

        $params = [
            'idClient' => User::inRandomOrder()->first()->id,
            'amount_to_receive' => (string) rand(1000,99999),
            'amount_received' => (string) rand(1000,99999),
            'reason' => $this->faker->sentence(),
            'payment_method' => $this->faker->word(),
            'irpp' => $this->faker->boolean(),
            'payment_date' => $this->faker->date(),
            'receipt_number' => $this->faker->bothify('RCPT-####??'),
            'operator' => $this->faker->word(), // ou ->name() selon le contexte
            'idTypeOfRecipe' => factory(TypeOfRecipe::class)->create()->id,
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/cashins/{$bo->id}", $params)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanTrashCashIn()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $cashin = CashIn::inRandomOrder()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->deleteJson("/api/cashins/trash/{$cashin->id}")
            ->assertStatus(200);

        $cashin->update([
            'updated_by' => auth()->user()->id,
            'deleted' => false
        ]);
    }

    public function testCanRestoreTrashedCashIn()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $bo = CashIn::inRandomOrder()->first();
        $bo->update([
            'updated_by' => auth()->user()->id,
            'deleted' => true
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/cashins/restore/{$bo->id}")
            ->assertStatus(200);
    }
}
