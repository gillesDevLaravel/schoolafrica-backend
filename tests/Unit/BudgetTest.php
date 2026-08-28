<?php

namespace Tests\Unit;

use App\Enums\BudgetTypeEnum;
use App\Http\Resources\TypeInvoiceResource;
use App\Models\Budget;
use App\Models\School;
use App\Models\TypeInvoice;
use App\Models\TypeOfRecipe;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BudgetTest extends TestCase
{
    use WithFaker;

    public function test_can_get_all_budgets()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $typeInvoice = factory(TypeInvoice::class)->create();
        $typeRecipe = factory(TypeOfRecipe::class)->create();

        $budgets = factory(Budget::class, 2)->create();

        foreach ($budgets as $budget) {
            if ($budget->type === BudgetTypeEnum::RECIPE) {
                $budget->typeOfRecipes()->attach($typeRecipe->id, [
                    'quantity' => 1,
                    'number' => 2,
                    'amount' => 1500,
                ]);
            } else {
                $budget->typeInvoices()->attach($typeInvoice->id, [
                    'quantity' => 2,
                    'number' => 3,
                    'amount' => 2500,
                ]);
            }
        }



        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/budgetsall');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'name',
                        'type',
                        'description',
                        'realisation',
                        'school',
                        'typeInvoiceOrRecipeItems',
                        'total_amount',
                        'creator' => [
                            'id',
                            'name',
                        ],
                    ],
                ],
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next',
                ],
                'meta' => [
                    'current_page',
                    'from',
                    'last_page',
                    'path',
                    'per_page',
                    'to',
                    'total',
                ],
            ]);

    }

    public function test_can_create_budget()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);


        $faker = $this->faker();

        $data = [
            'name' => $faker->word,
            'description' => $faker->sentence, // ou $faker->words(3, true)
            'realisation' => $faker->randomFloat(2, 0, 100), // 2 décimales, entre 0 et 100
            'idSchool' => School::inRandomOrder()->first()->id,

            'type' => $faker->randomElement(BudgetTypeEnum::values()),
            'type_invoice_or_type_recipe_items' => [
                [
                    'item_id' => null,
                    'quantity' => 2,
                    'number' => 3,
                    'amount' => 1500,
                ],
            ],
        ];
        $type = $faker->randomElement(BudgetTypeEnum::values());
        if ($type == BudgetTypeEnum::RECIPE){
            $typeRecipe = factory(TypeOfRecipe::class)->create();
            $data['type_invoice_or_type_recipe_items'][0]['item_id'] = $typeRecipe->id;
        }else{
            $typeInvoice = factory(TypeInvoice::class)->create();
            $data['type_invoice_or_type_recipe_items'][0]['item_id'] = $typeInvoice->id;
        }

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/budgets', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'budget.create.success',
                'data' => [
                    'name' => $data['name'],
                    'type' => $data['type'],
                    'description' => $data['description'],
                    'realisation' => $data['realisation'],
                ],
            ]);

// Vérifie que l'entrée a bien été enregistrée en base
        $this->assertDatabaseHas('budgets', [
            'name' => $data['name'],
            'type' => $data['type'],
        ]);
    }


    public function test_can_show_budget()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $userId = json_decode($login->getContent())->data->id;

        $budget = factory(Budget::class)->create([
//            'type' => 'Invoice',
            'created_by' => $userId,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token
        ])->getJson("/api/budgets/{$budget->id}");

        $response->assertJson([
            'data' => [
                'name' => $budget->name,
                'type' => ucfirst($budget->type),
                'description' => ucfirst($budget->description),
                'realisation' => ucfirst($budget->realisation),
                'typeInvoiceOrRecipeItems' => [],
                'total_amount' => 0,
                'creator' => [
                    'id' => $budget->created_by,
                    'name' => 'Fondateur',
                ],
                'school' => [
                    'id' => $budget->school_id,
                ],
            ],
        ]);

    }




    public function test_can_update_budget()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $userId = json_decode($login->getContent())->data->id;
        $faker = $this->faker();

        // Génération aléatoire du type
        $type = $faker->randomElement(BudgetTypeEnum::values());

        // Création d’un budget initial
        $budget = factory(Budget::class)->create([
            'type' => $type,
            'created_by' => $userId
        ]);

        // Création dynamique du bon type d'élément et préparation des données
        if ($type === BudgetTypeEnum::INVOICE) {
            $item = factory(TypeInvoice::class)->create();
        } else {
            $item = factory(TypeOfRecipe::class)->create();
        }

        $updateData = [
            'name' => $faker->word,
            'type' => $type,
            'description' => $faker->sentence,
            'realisation' => $faker->randomFloat(2, 0, 100),
            'idSchool' => School::inRandomOrder()->first()->id,
            'type_invoice_or_type_recipe_items' => [
                [
                    'item_id' => $item->id,
                    'quantity' => 5,
                    'number' => 2,
                    'amount' => 3200,
                ]
            ],
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token
        ])->putJson("/api/budgets/{$budget->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => __('budget.update.success'),
                'data' => [
                    'name' => $updateData['name'],
                    'description' => $updateData['description'],
                    'realisation' => $updateData['realisation'],
                    'type' => $type,
                    'creator' => [
                        'id' => $userId,
                    ],
                    'typeInvoiceOrRecipeItems' => [
                        [
                            'id' => $item->id,
                            'pivot' => [
                                'quantity' => 5,
                                'number' => 2,
                                'amount' => "3200.00",
                            ]
                        ]
                    ]
                ]
            ]);

        // Vérification en base de la table pivot
        $pivotTable = $type === BudgetTypeEnum::INVOICE ? 'budget_type_invoice' : 'budget_type_of_recipe';
        $pivotForeignKey = $type === BudgetTypeEnum::INVOICE ? 'type_invoice_id' : 'type_of_recipe_id';

        $this->assertDatabaseHas($pivotTable, [
            'budget_id' => $budget->id,
            $pivotForeignKey => $item->id,
            'quantity' => 5,
            'number' => 2,
            'amount' => 3200,
        ]);

        // Vérification en base de la table budgets
        $this->assertDatabaseHas('budgets', [
            'id' => $budget->id,
            'name' => $updateData['name'],
            'updated_by' => $userId,
        ]);
    }




    public function test_can_archive_budget()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $budget = factory(Budget::class)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->post("/api/budgets/trash", ['ids' => [$budget->id]]);

        $response->assertStatus(204);
        $this->assertSoftDeleted('budgets', ['id' => $budget->id]);
    }

    public function test_can_restore_budget()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $budget = factory(Budget::class)->create();
        $budget->delete();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->post("/api/budgets/restore", ['ids' => [$budget->id]]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'success' => true,
                'message' => __('budget.restore.success'),
            ]);

        $this->assertDatabaseHas('budgets', [
            'id' => $budget->id,
            'deleted_at' => null,
        ]);
    }

    public function test_can_delete_budget_permanently()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $budget = factory(Budget::class)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/budgets/delete", ['ids' => [$budget->id]]);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('budgets', ['id' => $budget->id]);
    }
}
