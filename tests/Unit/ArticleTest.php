<?php

namespace Tests\Unit;

use App\Enums\ArticleMovementOperationTypeEnum;
use App\Enums\ArticleTypeEnum;
use App\Models\Article;
use App\Models\PurchaseOrder;
use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use WithFaker;

    public function test_can_get_all_articles()
    {
        factoryCreateOneByOne(Article::class, 5);


        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/articlesall');


        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'idSchool',
                        'idSection',
                        'name',
                        'type',
                        'image',
                        'price',
                        'quantity',
                        'description',
                        'unit_of_measurement',
                        'alert_quantity',
                        'expiry_date',
                        'container',
                        'container_unit',
                        'container_quantity',
                        'detail',
                        // 'service',
                        'created_at',
                        'author' => [
                            'id',
                            'name',
                            'photo',
                            'email',
                            'phone',
                            'device_key',
                            'cni',
                            'idBourse',
                            'isBourseUsed',
                            'idRole',
                            'annualDecision',
                        ],
                        'suppliers' => [
                            '*' => [
                                'id',
                                'name',
                                'phone',
                            ],
                        ],
                    ],
                ],
            ]);
    }

    public function test_can_create_article()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $expiryDate = $this->faker->dateTimeBetween('now', '+1 year');
        $formattedExpiryDate = $expiryDate->format('Y-m-d');
        $price = $this->faker->randomFloat(2, 1, 100);

        $data = [
            'articles' => [
                [
                    'idSchool' => School::inRandomOrder()->first()->id,
                    'name' => $this->faker->word,
                    'image' => $this->faker->word,
                    'type' => $this->faker->randomElement(ArticleTypeEnum::values()),
                    'price' => $price,
                    'description' => $this->faker->sentence(10),
                    'unit_of_measurement' => $this->faker->randomElement(['kg', 'g', 'mg', 'L', 'ml', 'cm', 'm', 'pcs', 'units']),
                    'alert_quantity' => $this->faker->numberBetween(1, 100),
                    'expiry_date' => $formattedExpiryDate,

                    'container' => $this->faker->word, // exemple : "box", "bottle"
                    'container_unit' => $this->faker->randomElement(['litre', 'kilogram', 'unit', 'pack']),
                    'container_quantity' => $this->faker->numberBetween(1, 100),
                    'detail' => $this->faker->sentence,

//                    'service_id' => Service::inRandomOrder()->value('id') ?? Service::factory()->create()->id,
                ],
            ],
        ];



        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/articles', $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('articles', [
            'name' => $data['articles'][0]['name'],
            'description' => $data['articles'][0]['description'],
            'unit_of_measurement' => $data['articles'][0]['unit_of_measurement'],
            'alert_quantity' => $data['articles'][0]['alert_quantity'],
//            'service_id' => $data['articles'][0]['service_id'],
            'created_by' => auth()->id(),
        ]);
    }


    public function test_can_create_article_movements()
    {
        // Connexion
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000',
        ]);

        // Préparation des données nécessaires
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();
        $purchaseOrder = factory(PurchaseOrder::class)->create();

        $data = [
            'article_movements' => [
                [
                    'article_id' => $article->id,
                    'quantity' => 0,
                    'reason' => 'Stock initial',
                    'description' => 'Ajout initial de stock',
                    'operation_type' => ArticleMovementOperationTypeEnum::ENTRY,
                    'idUser' => $user->id,
                    'purchase_order_id' => $purchaseOrder->id,
                    'date' => now()->toDateString(),
                ],
                [
                    'article_id' => $article->id,
                    'quantity' => 0,
                    'reason' => 'Utilisation en labo',
                    'description' => 'Sortie pour TP',
                    'operation_type' => ArticleMovementOperationTypeEnum::EXIT,
                    'idUser' => $user->id,
                    'purchase_order_id' => null,
                    'date' => now()->toDateString(),
                ]
            ],
        ];

        // Envoi de la requête
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token,
        ])->postJson('/api/article-movements', $data);

        $response->assertStatus(200); // ou 200 selon ton contrôleur

        // Vérification dans la base de données
        foreach ($data['article_movements'] as $movement) {
            $this->assertDatabaseHas('article_movements', [
                'article_id' => $movement['article_id'],
                'quantity' => $movement['quantity'],
                'reason' => $movement['reason'],
                'operation_type' => $movement['operation_type'],
                'user_id' => $movement['idUser'],
            ]);
        }
    }




    public function test_can_show_article()
    {
        $article = factory(Article::class)->create();

        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->getJson("/api/articles/{$article->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $article['id'],
                    'name' => $article['name'],
                    'price' => $article['price'],
                    'description' => $article['description'],
                    'unit_of_measurement' => $article['unit_of_measurement'],
                    'alert_quantity' => $article['alert_quantity'],

                    'container' => $article['container'],
                    'container_unit' => $article['container_unit'],
                    'container_quantity' => $article['container_quantity'],
                    'detail' => $article['detail'],

//                    'service' => [
//                        'id' => $article['service_id'],
//                    ],
                    'author' => [
                        'id' => $article['created_by'],
                    ],
                    'created_at' => $article['created_at']->toDateString(),
                ],
            ]);
    }

    public function test_can_update_article()
    {
//        $this->createFakeRessources();

        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $article = factory(Article::class)->create();

//        $service = Service::inRandomOrder()->first();

        $data = [
            'name' => $this->faker->word,
            'image' => $this->faker->word,
            'type' => $this->faker->randomElement(ArticleTypeEnum::values()),
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'description' => $this->faker->text(15),
            'unit_of_measurement' => $this->faker->randomElement(['kg', 'g', 'mg', 'L', 'ml', 'cm', 'm', 'pcs', 'units']),
            'alert_quantity' => $this->faker->numberBetween(1, 100),

            'container' => $this->faker->word, // exemple : "box", "bottle"
            'container_unit' => $this->faker->randomElement(['litre', 'kilogram', 'unit', 'pack']),
            'container_quantity' => $this->faker->numberBetween(1, 100),
            'detail' => $this->faker->sentence,

//            'service_id' => $service->id,
        ];


        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/articles/{$article->id}", $data);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $article->id,
                'name' => $data['name'],
                'price' => $data['price'],
                'description' => $data['description'],
                'unit_of_measurement' => $data['unit_of_measurement'],
                'alert_quantity' => $data['alert_quantity'],

                'container' => $data['container'],
                'container_unit' => $data['container_unit'],
                'container_quantity' => $data['container_quantity'],
                'detail' => $data['detail'],
            ]);
//            ->assertJsonPath('data.service.id', $service->id)
//            ->assertJsonPath('data.service.name', $service->name);

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description'],
            'unit_of_measurement' => $data['unit_of_measurement'],
            'alert_quantity' => $data['alert_quantity'],
//            'service_id' => $data['service_id'],

            'container' => $data['container'],
            'container_unit' => $data['container_unit'],
            'container_quantity' => $data['container_quantity'],
            'detail' => $data['detail'],
        ]);
    }

    public function test_can_archive_article()
    {
        $article = factory(Article::class)->create();


        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->post("/api/articles/trash", ['ids' => [$article->id]]);

        $response->assertStatus(204);
        $this->assertSoftDeleted('articles', ['id' => $article->id]);
    }

    public function test_can_restore_article()
    {
        $article = factory(Article::class)->create();
        $article->delete();

        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->post("/api/articles/restore", ['ids' => [$article->id]]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'success' => true,
                'message' => __('article.restore.success'),
            ]);

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'deleted_at' => null,
        ]);
    }

    public function test_can_delete_article_permanently()
    {

        $article = factory(Article::class)->create();


        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/articles/delete", ['ids' => [$article->id]]);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }
}
