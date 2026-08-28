<?php

namespace Tests\Unit;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use WithFaker;

    public function testCanGetCustomers(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/customersall', [
                'idSchool' => 2
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data', 'meta', 'links'
            ]);
    }

    public function testCanCreateCustomer()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $customers = [
            [
                'name' => $this->faker->name,
                'amount' => rand(1000,9999),
                'adresse' => $this->faker->address,
                'type' => 'entreprise',
                'phone' => $this->faker->phoneNumber,
                'mobile' => $this->faker->phoneNumber,
                'email' => $this->faker->email,
            ],
            [
                'name' => $this->faker->name,
                'amount' => rand(1000,9999),
                'adresse' => $this->faker->address,
                'type' => 'personnel',
                'phone' => $this->faker->phoneNumber,
                'mobile' => $this->faker->phoneNumber,
                'email' => $this->faker->email,
            ],
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/customers', [
                'customers' => $customers
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanUpdateCustomer()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $bo = Customer::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/customers/{$bo->id}", [
                'name' => $this->faker->name,
                'amount' => rand(1000,9999),
                'adresse' => $this->faker->address,
                'type' => 'personnel',
                'phone' => $this->faker->phoneNumber,
                'mobile' => $this->faker->phoneNumber,
                'email' => $this->faker->email,
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanDeleteCustomer()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $bo = Customer::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->deleteJson("/api/customers/{$bo->id}")
            ->assertStatus(200);
    }
}
