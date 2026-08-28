<?php

namespace Tests\Unit;

use App\Http\Resources\TypeInvoiceResource;
use App\Models\Budget;
use App\Models\TypeOfRecipe;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function Symfony\Component\Translation\t;

class TypeOfRecipeTest extends TestCase
{
    use WithFaker;

    public function test_can_get_all_type_of_recipes()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

//        factory(TypeOfRecipe::class, 5)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/type-of-recipesall');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'code',
                        'category',
                        'school',
                    ],
                ],
            ]);
    }

    public function test_can_create_multiple_type_of_recipes()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $faker = $this->faker();

        $data = [
            'type_of_recipes' => [
                [
                    'name' => $faker->word,
                    'code' => strtoupper($faker->bothify('???####')),
                    'category' => $faker->word,
                    'idSchool' => null
                ],
                [
                    'name' => $faker->word,
                    'category' => $faker->word,
                    'idSchool' => null
                ]
            ]
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token
        ])
            ->postJson('/api/type-of-recipes', $data);

        $response->assertStatus(201);

        // Vérifie que chaque entrée a bien été insérée dans la base
        foreach ($data['type_of_recipes'] as $item) {
            $this->assertDatabaseHas('type_of_recipes', [
                'name' => $item['name'],
                'category' => $item['category'],
            ]);
        }
    }


    public function test_can_show_type_of_recipe()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $type_of_recipe = factory(TypeOfRecipe::class)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token
        ])->getJson("/api/type-of-recipes/{$type_of_recipe->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => $type_of_recipe->name,
                    'category' => $type_of_recipe->category,
                ],
            ]);
    }


    public function test_can_update_type_of_recipe()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $typeOfRecipe = factory(TypeOfRecipe::class)->create();

        $faker = $this->faker();

        $data = [
            'name' => $faker->word,
            'code' => strtoupper($faker->bothify('???####')),
            'category' => $faker->word,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token
        ])->putJson("/api/type-of-recipes/{$typeOfRecipe->id}", $data);


        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => $data['name'],
                    'category' => $data['category'],
                ],
            ]);


        $this->assertDatabaseHas('type_of_recipes', [
            'id' => $typeOfRecipe->id,
            'name' => $data['name'],
            'category' => $data['category'],
        ]);
    }


    public function test_can_archive_type_of_recipe()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $typeOfRecipe = factory(TypeOfRecipe::class)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->post("/api/type-of-recipes/trash", ['ids' => [$typeOfRecipe->id]]);

        $response->assertStatus(204);
        $this->assertSoftDeleted('type_of_recipes', ['id' => $typeOfRecipe->id]);
    }
    public function test_can_restore_type_of_recipe()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $typeOfRecipe = factory(TypeOfRecipe::class)->create();
        $typeOfRecipe->delete();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token
        ])->post("/api/type-of-recipes/restore", ['ids' => [$typeOfRecipe->id]]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'success' => true,
                'message' => __('type_of_recipe.restore.success'),
            ]);

        $this->assertDatabaseHas('type_of_recipes', [
            'id' => $typeOfRecipe->id,
            'deleted_at' => null,
        ]);
    }


    public function test_can_delete_type_of_recipe_permanently()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $typeOfRecipe = factory(TypeOfRecipe::class)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token
        ])->postJson("/api/type-of-recipes/delete", ['ids' => [$typeOfRecipe->id]]);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('type_of_recipes', [
            'id' => $typeOfRecipe->id,
        ]);
    }

}
