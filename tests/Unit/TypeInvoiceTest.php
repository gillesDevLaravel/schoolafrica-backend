<?php

namespace Tests\Unit;

use App\Models\TypeInvoice;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TypeInvoiceTest extends TestCase
{
    use WithFaker;

    public function test_can_list_type_invoices()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/typeinvoicesall')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_show_type_invoice()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $typeInvoice = factory(TypeInvoice::class)->create();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->getJson("/api/typeinvoices/{$typeInvoice->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'code',
                    'category',
                    'school_id' // This is a nested resource object
                ]
            ]);

        $typeInvoice->delete();
    }

    public function test_can_create_type_invoice_with_store_request()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $typeInvoiceData = [
            'type_invoices' => [
                [
                    'name' => $this->faker->word . ' ' . time(),
                    'code' => 'TI' . $this->faker->unique()->randomNumber(4),
                    'category' => $this->faker->randomElement(['scolarite', 'transport', 'cantine', 'autre']),
                    'idSchool' => null
                ]
            ]
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/typeinvoices', $typeInvoiceData)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        // Clean up
        TypeInvoice::where('name', $typeInvoiceData['type_invoices'][0]['name'])->delete();
    }

    public function test_can_create_multiple_type_invoices()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $timestamp = time();
        $typeInvoiceData = [
            'type_invoices' => [
                [
                    'name' => $this->faker->word . ' ' . $timestamp . '_1',
                    'code' => 'TI' . $this->faker->unique()->randomNumber(4),
                    'category' => 'scolarite',
                    'idSchool' => null
                ],
                [
                    'name' => $this->faker->word . ' ' . $timestamp . '_2',
                    'code' => 'TI' . $this->faker->unique()->randomNumber(4),
                    'category' => 'transport',
                    'idSchool' => null
                ]
            ]
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/typeinvoices', $typeInvoiceData)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        // Clean up
        TypeInvoice::where('name', 'like', '%' . $timestamp . '_1%')->delete();
        TypeInvoice::where('name', 'like', '%' . $timestamp . '_2%')->delete();
    }

    public function test_cannot_create_type_invoice_without_name()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $typeInvoiceData = [
            'type_invoices' => [
                [
                    'name' => '',
                    'code' => 'TI' . $this->faker->unique()->randomNumber(4),
                    'category' => 'scolarite',
                    'idSchool' => null
                ]
            ]
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/typeinvoices', $typeInvoiceData)
            ->assertStatus(422);
    }

    public function test_cannot_create_type_invoice_without_category()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $typeInvoiceData = [
            'type_invoices' => [
                [
                    'name' => $this->faker->word . ' ' . time(),
                    'code' => 'TI' . $this->faker->unique()->randomNumber(4),
                    'category' => '',
                    'idSchool' => null
                ]
            ]
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/typeinvoices', $typeInvoiceData)
            ->assertStatus(422);
    }

    public function test_cannot_create_type_invoice_without_type_invoices_array()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $typeInvoiceData = [
            'name' => $this->faker->word,
            'code' => 'TI' . $this->faker->unique()->randomNumber(4),
            'category' => 'scolarite',
            'idSchool' => null
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/typeinvoices', $typeInvoiceData)
            ->assertStatus(422);
    }

    public function test_can_update_type_invoice_with_update_request()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $typeInvoice = factory(TypeInvoice::class)->create();

        $updateData = [
            'name' => $this->faker->word . ' updated',
            'code' => 'TI' . $this->faker->unique()->randomNumber(4),
            'category' => 'cantine',
            'idSchool' => null
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/typeinvoices/{$typeInvoice->id}", $updateData)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'code',
                    'category',
                    'school_id'
                ]
            ]);

        $typeInvoice->delete();
    }

    public function test_can_update_type_invoice_with_partial_data()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $typeInvoice = factory(TypeInvoice::class)->create([
            'name' => 'Original Name',
            'category' => 'scolarite'
        ]);

        $updateData = [
            'name' => 'Updated Name'
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/typeinvoices/{$typeInvoice->id}", $updateData);

        $response->assertStatus(200);

        $typeInvoice->delete();
    }

    public function test_can_delete_type_invoice()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $typeInvoice = factory(TypeInvoice::class)->create();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->deleteJson("/api/typeinvoices/{$typeInvoice->id}")
            ->assertStatus(204);
    }

    public function test_can_filter_type_invoices_by_type()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        // Create type invoices with different types
        $typeInvoice1 = factory(TypeInvoice::class)->create(['type' => 'scolarite']);
        $typeInvoice2 = factory(TypeInvoice::class)->create(['type' => 'transport']);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/typeinvoicesall', ['type' => 'scolarite'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        // Clean up
        $typeInvoice1->delete();
        $typeInvoice2->delete();
    }
}
