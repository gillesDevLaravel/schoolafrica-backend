<?php

namespace Tests\Unit;

use App\Enums\PurchaseOrderPaymentMethodEnum;
use App\Enums\PurchaseOrderPaymentStatusEnum;
use App\Enums\PurchaseOrderPriorityEnum;
use App\Enums\PurchaseOrderStatusEnum;
use App\Models\Article;
use App\Models\PurchaseOrder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PuchaseOrderTest extends TestCase
{
    use WithFaker;

    protected function generateRandomDataArticleWithUnitPriceAndQuantity()
    {
        $max = Article::count();
        $articles = factoryCreateOneByOne(Article::class, 2);


        $articleData = [];
        foreach ($articles as $article) {
            $quantity = rand(1, 10);
            $unitPrice = rand(100, 1000);
            $articleData[] = [
                'id' => $article->id,
                'unit_price' => $unitPrice,
                'quantity' => $quantity,
            ];
        }

        return $articleData;
    }

    public function test_can_get_all_purchase_orders()
    {

//        factoryCreateOneByOne(PurchaseOrder::class, 5);

        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/purchase-ordersall');

//        dd($response->getContent());

        $response->assertStatus(200)
            ->assertJsonStructure([
                'total_amount',
                'total_amount_paid',
                'total_rest',
                'data' => [
                    '*' => [
                        'id',
                        'description',
                        'validation_date',
                        'order_received_date',
                        'status',
                        'payment_method',
                        'payment_status',
                        'priority',
                        'quotation_file',
                        'supplier',
                        'responsible',
                        'articles',
                        'total_amount',
                    ],
                ],
            ]);
    }

    public function test_can_create_purchase_orders()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        // Données de test
        $data = [
            'supplier_id' => User::inRandomOrder()->first()->id,
            'responsible_id' => User::inRandomOrder()->first()->id,
            'description' => $this->faker->sentence,
            'status' => $this->faker->randomElement(PurchaseOrderStatusEnum::values()),
            'payment_method' => $this->faker->randomElement(PurchaseOrderPaymentMethodEnum::values()),
            'payment_status' => $this->faker->randomElement(PurchaseOrderPaymentStatusEnum::values()),
            'quotation_file' => null,
            'priority' => $this->faker->randomElement(PurchaseOrderPriorityEnum::values()),
            'articles' => $this->generateRandomDataArticleWithUnitPriceAndQuantity(),
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/purchase-orders', $data);

//        dd($response->getContent());
        // Vérifications
        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'message' => __('purchase_order.create.success'),
            'data' => [
                'supplier' => ['id' => $data['supplier_id']],
                'responsible' => ['id' => $data['responsible_id']],
                'description' => $data['description'],
                'status' => $data['status'],
                'priority' => $data['priority'],
                'payment_status' => $data['payment_status'],
                'quotation_file' => $data['quotation_file'],
            ],
        ]);

        // Vérifier que le bon d'achat a bien été inséré en base
        $this->assertDatabaseHas('purchase_orders', [
            'supplier_id' => $data['supplier_id'],
            'responsible_id' => $data['responsible_id'],
            'description' => $data['description'],
            'status' => $data['status'],
            'priority' => $data['priority'],
            'payment_status' => $data['payment_status'],
            'quotation_file' => $data['quotation_file'],
        ]);
    }

    public function test_can_show_purchase_orders()
    {
        $purchaseOrder = factory(PurchaseOrder::class)->create([
            'payment_status' => PurchaseOrderPaymentStatusEnum::ADVANCE,
        ]);

        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->getJson("/api/purchase-orders/{$purchaseOrder->id}");

//        dd($response->getContent());

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $purchaseOrder['id'],
                    'description' => $purchaseOrder['description'],
                    'status' => $purchaseOrder['status'],
                    'priority' => $purchaseOrder['priority'],
                    'payment_status' => $purchaseOrder['payment_status'],
                    'quotation_file' => $purchaseOrder['quotation_file'],
                    'supplier' => [
                        'id' => $purchaseOrder['supplier_id'],
                    ],
                    'responsible' => [
                        'id' => $purchaseOrder['responsible_id'],
                    ],
                    'articles' => [],
                    'total_amount' => 0,
                ],
            ]);
    }

    public function test_can_update_purchase_order()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        // On choisit un utilisateur pour le connecter et en faire le responsable
        $responsible = auth()->user();

        // Choisir un fournisseur différent
        $supplier = User::where('id', '!=', $responsible->id)->inRandomOrder()->first();

        // Créer un bon d'achat existant avec ce responsable
        $purchaseOrder = factory(PurchaseOrder::class)->create([
            'supplier_id' => $supplier->id,
            'responsible_id' => auth()->user(),
            'status' => PurchaseOrderStatusEnum::PURCHASE_ORDER
        ]);

        // Données de mise à jour
        $data = [
            'description' => $this->faker->sentence,
            'validation_date' => null,
            'order_received_date' => null,
            'status' => $this->faker->randomElement(PurchaseOrderStatusEnum::values()),
            'payment_method' => $this->faker->randomElement(PurchaseOrderPaymentMethodEnum::values()),
            'payment_status' => $this->faker->randomElement(PurchaseOrderPaymentStatusEnum::values()),
            'priority' => $this->faker->randomElement(PurchaseOrderPriorityEnum::values()),
            'supplier_id' => $supplier->id,
            'responsible_id' => $responsible->id,
//            'payment_method' => $this->faker->randomElement(DisbursementPaymentMethodEnum::values()),
            'articles' => $this->generateRandomDataArticleWithUnitPriceAndQuantity(),
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/purchase-orders/{$purchaseOrder->id}", $data);

//        dd($response->getContent());
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => __('purchase_order.update.success'),
                'data' => [
                    'id' => $purchaseOrder->id,
                    'description' => $data['description'],
                    'status' => $data['status'],
                    'priority' => $data['priority'],
                    'payment_status' => $data['payment_status'],
                    'supplier' => ['id' => $supplier->id],
                    'responsible' => ['id' => $responsible->id],
                ],
            ]);

        $this->assertDatabaseHas('purchase_orders', [
            'id' => $purchaseOrder->id,
            'description' => $data['description'],
            'status' => $data['status'],
            'priority' => $data['priority'],
            'payment_status' => $data['payment_status'],
            'supplier_id' => $supplier->id,
            'responsible_id' => $responsible->id,
        ]);
    }

    public function test_can_archive_purchase_order()
    {
        $purchase_order = factory(PurchaseOrder::class)->create();


        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->post("/api/purchase-orders/trash", ['ids' => [$purchase_order->id]]);

        $response->assertStatus(204);
        $this->assertSoftDeleted('purchase_orders', ['id' => $purchase_order->id]);
    }

    public function test_can_restore_purchase_order()
    {
        $purchase_order = factory(PurchaseOrder::class)->create();
        $purchase_order->delete();

        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->post("/api/purchase-orders/restore", ['ids' => [$purchase_order->id]]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'success' => true,
                'message' => __('purchase_order.restore.success'),
            ]);

        $this->assertDatabaseHas('purchase_orders', [
            'id' => $purchase_order->id,
            'deleted_at' => null,
        ]);
    }

    public function test_can_delete_purchase_order_permanently()
    {
        $purchase_order = factory(PurchaseOrder::class)->create();
        $purchase_order->delete();

        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->post("/api/purchase-orders/delete", ['ids' => [$purchase_order->id]]);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('purchase_orders', ['id' => $purchase_order->id]);
    }
}
