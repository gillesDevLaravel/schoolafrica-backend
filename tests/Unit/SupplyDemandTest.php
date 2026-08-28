<?php

namespace Tests\Unit;

use App\Enums\SupplyDemandPriorityEnum;
use App\Enums\SupplyDemandStatusEnum;
use App\Models\Article;
use App\Models\PurchaseOrder;
use App\Models\SupplyDemand;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SupplyDemandTest extends TestCase
{
    use WithFaker;

    public function test_can_get_all_supply_demands()
    {

        factoryCreateOneByOne(SupplyDemand::class, 5);

        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->post("/api/supply-demandsall");

//dd($response->getContent());

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',  // Ajouté car "name" est une clé dans chaque élément de "data"
                        'description',
                        'responsible_id',
//                        'responsible' => [
//                            'id',    // Responsable avec ID et autres informations
//                            'name',
//                            'phone'
//                        ],
                        'status',
                        'priority',  // Priority est aussi une clé dans chaque élément de "data"
                        'articles',
                    ],
                ],
                'links',
                'meta',
            ]);

    }

    public function test_can_filter_supply_demands_by_date_range()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $token = json_decode($login->getContent())->data->token;
        $responsible = factory(User::class)->create();

        $supplyDemandInRange = factory(SupplyDemand::class)->create([
            'responsible_id' => $responsible->id,
            'created_at' => now()->subDays(2),
            'updated_at' => now()->subDays(2),
        ]);

        $supplyDemandOutRange = factory(SupplyDemand::class)->create([
            'responsible_id' => $responsible->id,
            'created_at' => now()->subDays(10),
            'updated_at' => now()->subDays(10),
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->post('/api/supply-demandsall', [
                'responsible_id' => $responsible->id,
                'date_start' => now()->subDays(3)->toDateString(),
                'date_end' => now()->subDay()->toDateString(),
            ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $supplyDemandInRange->id])
            ->assertJsonMissing(['id' => $supplyDemandOutRange->id]);
    }

    public function test_can_create_supply_demand()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $articles = factoryCreateOneByOne(Article::class, 5);
        $users = factory(User::class, 5)->create();

        $data = [
//            'name'           => $this->faker->word,
//            'description'    => $this->faker->sentence(10),
            'name'           => null,
            'description'    => null,
            'responsible_id' => $users->random()->id,
            'status'         => $this->faker->randomElement(SupplyDemandStatusEnum::values()),
            'priority'       => $this->faker->randomElement(SupplyDemandPriorityEnum::values()),
            'articles' => $articles->random(3)->map(function ($article) use ($users) {
                return [
                    'id' => $article->id,
                    'unit_price' => $this->faker->numberBetween(10, 100), // Entier au lieu de décimal
                    'quantity' => $this->faker->numberBetween(1, 10),
                    'supplier_id' => $users->random()->id,
                ];
            })->toArray(),
        ];


        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->post("/api/supply-demands", $data);

//        dd($response->getContent());

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => __('supply_demand.create.success'),
            ])
            ->assertJsonPath('data.description', $data['description']);

        // Vérification en base de données
        $this->assertDatabaseHas('supply_demands', [
            'description' => $data['description'],
            'created_by' => auth()->id(),
        ]);

        // Vérification des articles associés
        $createdSupplyDemand = SupplyDemand::latest()->first();
        $this->assertCount(3, $createdSupplyDemand->articles);
    }


    public function test_can_show_supply_demand()
    {
        $supplyDemand = factory(SupplyDemand::class)->create();

        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->get("/api/supply-demands/{$supplyDemand->id}");

//        dd($response->getContent());

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $supplyDemand->id,
                    'description' => $supplyDemand->description,
                ],
            ]);
    }

    public function test_can_update_supply_demand()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $user = factory(User::class)->create(); // Responsable requis
        $supplier = factory(User::class)->create(); // Fournisseur
        $articles = factoryCreateOneByOne(Article::class, 3);

        // Création initiale avec des articles
        $supplyDemand = factory(SupplyDemand::class)
            ->create([
                'name' => 'Ancien nom',
                'responsible_id' => auth()->id(),
                'status' => SupplyDemandStatusEnum::PENDING,
            ]);

        attachArticlesToSupplyDemand($supplyDemand);

        $data = [
            'name' => 'Nom modifié',
            'description' => $this->faker->sentence(12),
            'responsible_id' => $user->id,
            'status' => SupplyDemandStatusEnum::values()[0],
            'priority' => SupplyDemandPriorityEnum::values()[0],
            'articles' => $articles->map(function ($article) use ($supplier) {
                return [
                    'id' => $article->id,
                    'unit_price' => $this->faker->numberBetween(10, 100), // entier comme demandé par la validation
                    'quantity' => $this->faker->numberBetween(1, 10),
                    'supplier_id' => $supplier->id, // fournisseur spécifique
                ];
            })->toArray(),
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->put("/api/supply-demands/{$supplyDemand->id}", $data);

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $supplyDemand->id)
            ->assertJsonPath('data.name', $data['name'])
            ->assertJsonPath('data.description', $data['description'])
            ->assertJsonPath('data.status', $data['status'])
            ->assertJsonPath('data.priority', $data['priority']);

        $this->assertDatabaseHas('supply_demands', [
            'id' => $supplyDemand->id,
            'name' => $data['name'],
            'description' => $data['description'],
            'responsible_id' => $data['responsible_id'],
            'status' => $data['status'],
            'priority' => $data['priority'],
            'updated_by' => auth()->id(), // Vérifie que updated_by est bien mis à jour
        ]);

        // Vérification des articles associés
        $updatedSupplyDemand = SupplyDemand::with('articles')->find($supplyDemand->id);
        $this->assertCount(3, $updatedSupplyDemand->articles);

        // Vérification des données pivot
        foreach ($data['articles'] as $articleData) {
            $this->assertDatabaseHas('article_supply_demand', [
                'supply_demand_id' => $supplyDemand->id,
                'article_id' => $articleData['id'],
//                'unit_price' => $articleData['unit_price'],
                'quantity' => $articleData['quantity'],
                'supplier_id' => $articleData['supplier_id'],
            ]);
        }
    }

    public function test_update_creates_purchase_order_when_status_approved()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $user = factory(User::class)->create(); // Responsable
        $supplier1 = factory(User::class)->create(); // Fournisseur 1
        $supplier2 = factory(User::class)->create(); // Fournisseur 2

        // Créer la demande
        $supplyDemand = factory(SupplyDemand::class)->create([
            'responsible_id' => auth()->id(),
            'status' => SupplyDemandStatusEnum::PENDING,
        ]);

        // Créer des articles
        $articlesSupplier1 = factoryCreateOneByOne(Article::class, 2);
        $articlesSupplier2 = factory(Article::class, 1)->create();

        // Associer les articles à la demande avec les fournisseurs
        foreach ($articlesSupplier1 as $article) {
            $supplyDemand->articles()->attach($article->id, [
                'unit_price' => 50,
                'quantity' => 3,
                'supplier_id' => $supplier1->id,
            ]);
        }

        foreach ($articlesSupplier2 as $article) {
            $supplyDemand->articles()->attach($article->id, [
                'unit_price' => 75,
                'quantity' => 2,
                'supplier_id' => $supplier2->id,
            ]);
        }

        // On prépare les données en respectant les règles de validation
        $data = [
            'status' => SupplyDemandStatusEnum::ACCEPTED,
            'articles' => array_merge(
                $articlesSupplier1->map(function ($article) use ($supplier1) {
                    return [
                        'id' => $article->id,
                        'unit_price' => 50,
                        'quantity' => 3,
                        'supplier_id' => $supplier1->id,
                    ];
                })->toArray(),
                $articlesSupplier2->map(function ($article) use ($supplier2) {
                    return [
                        'id' => $article->id,
                        'unit_price' => 75,
                        'quantity' => 2,
                        'supplier_id' => $supplier2->id,
                    ];
                })->toArray()
            ),
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->put("/api/supply-demands/{$supplyDemand->id}", $data);

//        dd($response->getContent());

        $response->assertStatus(200);

        // Vérifie la création des bons de commande
        $this->assertDatabaseHas('purchase_orders', [
            'supplier_id' => $supplier1->id,
        ]);

        $this->assertDatabaseHas('purchase_orders', [
            'supplier_id' => $supplier2->id,
        ]);

        // Vérifie l'association des articles aux bons de commande
        $purchaseOrder1 = PurchaseOrder::where('supplier_id', $supplier1->id)->first();
        $this->assertCount(2, $purchaseOrder1->articles);

        $purchaseOrder2 = PurchaseOrder::where('supplier_id', $supplier2->id)->first();
        $this->assertCount(1, $purchaseOrder2->articles);
    }


    public function test_can_trash_supply_demand()
    {
        $supplyDemand = factory(SupplyDemand::class)->create();

        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000',
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/supply-demands/trash", ['ids' => [$supplyDemand->id]]);

//        dd($response->getContent());

        $response->assertStatus(204);
        $this->assertSoftDeleted('supply_demands', ['id' => $supplyDemand->id]);
    }

    public function test_can_restore_supply_demand()
    {
        $supplyDemand = factory(SupplyDemand::class)->create();
        $supplyDemand->delete();

        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000',
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/supply-demands/restore", ['ids' => [$supplyDemand->id]]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'success' => true,
                'message' => __('supply_demand.restore.success'),
            ])
            ->assertJsonPath('data.0.id', $supplyDemand->id);

        $this->assertDatabaseHas('supply_demands', [
            'id' => $supplyDemand->id,
            'deleted_at' => null,
        ]);
    }

    public function test_can_delete_supply_demand_permanently()
    {
        $supplyDemand = factory(SupplyDemand::class)->create();
        $supplyDemand->delete();

        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000',
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/supply-demands/delete", ['ids' => [$supplyDemand->id]]);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('supply_demands', ['id' => $supplyDemand->id]);
    }

}
