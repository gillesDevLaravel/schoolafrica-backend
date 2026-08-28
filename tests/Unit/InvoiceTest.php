<?php

namespace Tests\Unit;

use App\Models\Invoice;
use App\Models\PurchaseOrder;
use App\Models\Product;
use App\Models\SalaryComponent;
use App\Models\TypeInvoice;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use WithFaker;

    public function testCanGetInvoices(){
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);


        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/invoicesall', [
                'idSchool' => 2
            ]);

//        dd($response->getContent());

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data', 'meta', 'sommes', 'om', 'cash', 'bank'
            ]);
    }

    public function testCanCreateInvoice()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $typeInvoice = TypeInvoice::inRandomOrder()->first() ?? factory(TypeInvoice::class)->create();
        $purchaseOrder = factory(PurchaseOrder::class)->create();
        $salaryComponents = factory(SalaryComponent::class, 2)->create();
        $salaryComponentsPayload = $salaryComponents->map(function ($component) {
            $unitPrice = rand(100, 500);
            $quantity = rand(1, 3);

            return [
                'salary_component_id' => $component->id,
                'unit_price' => $unitPrice,
                'quantity' => $quantity,
                'base_amount' => $unitPrice,
                'coef' => $quantity,
                'base_patronal' => rand(50, 200),
                'coef_patronal' => rand(1, 3),
            ];
        })->toArray();

        $invoices = [
            [
                'amount' => rand(1000,9999),
                'reasons' => $this->faker->text(200),
                'description' => $this->faker->text(45),
                'payment_deadline' => $this->faker->date(),
                'date' => $this->faker->date(),
                'idSchool' => 2,
                'idSection' => 2,
                'created_by' => rand(1, User::count()),
                'typeUser' => 'user',
                'idUser' => 2,
                'statut' => 'unpaid',
                'mode' => 'mode oooh',
                'number' => $this->faker->randomNumber(),
                'idTypeInvoice' => $typeInvoice->id,
                'type_produit' => $this->faker->text(15),
                'quantite' => $this->faker->randomNumber(),
                'prix_unitaire' => $this->faker->randomNumber(),
                'purchase_order_id' => $purchaseOrder->id,
                'salary_components' => $salaryComponentsPayload,
            ],
            [
                'amount' => rand(1000,9999),
                'reasons' => $this->faker->text(15),
                'description' => $this->faker->text(45),
                'payment_deadline' => $this->faker->date(),
                'date' => $this->faker->date(),
                'idSchool' => 1,
                'created_by' => rand(1, User::count()),
                'typeUser' => 'customer',
                'idUser' => 2,
                'statut' => 'unpaid',
                'mode' => 'mode oooh',
                'number' => $this->faker->randomNumber(),
                'idTypeInvoice' => $typeInvoice->id,
                'idProduct' => factory(Product::class)->create()->id,
            ],
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/invoices', [
                'invoices' => $invoices
            ]);


        $response->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanUpdateInvoice()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $bo = Invoice::latest()->first();
        $purchaseOrder = factory(PurchaseOrder::class)->create();
        $typeInvoice = TypeInvoice::inRandomOrder()->first() ?? factory(TypeInvoice::class)->create();
        $product = Product::inRandomOrder()->first() ?? factory(Product::class)->create();
        $salaryComponents = factory(SalaryComponent::class, 2)->create();
        $salaryComponentsPayload = $salaryComponents->map(function ($component) {
            $unitPrice = rand(100, 500);
            $quantity = rand(1, 3);

            return [
                'salary_component_id' => $component->id,
                'unit_price' => $unitPrice,
                'quantity' => $quantity,
                'base_amount' => $unitPrice,
                'coef' => $quantity,
                'base_patronal' => rand(50, 200),
                'coef_patronal' => rand(1, 3),
            ];
        })->toArray();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/invoices/{$bo->id}", [
                'amount' => rand(1000,9999),
                'reasons' => $this->faker->text(15),
                'description' => $this->faker->text(45),
                'payment_deadline' => $this->faker->date(),
                'date' => $this->faker->date(),
                'idSchool' => 1,
                'created_by' => rand(1, User::count()),
                'type' => 'customer',
                'idUser' => 2,
                'statut' => 'unpaid',
                'mode' => 'mode oooh',
                'number' => $this->faker->randomNumber(),
                'idTypeInvoice' => $typeInvoice->id,
                'idProduct' => $product->id,
                'purchase_order_id' => $purchaseOrder->id,
                'salary_components' => $salaryComponentsPayload,
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanDeleteInvoice()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $bo = Invoice::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->deleteJson("/api/invoices/{$bo->id}")
            ->assertStatus(200);
    }
}
