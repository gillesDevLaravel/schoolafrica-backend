<?php

namespace Tests\Unit;

use App\Models\SalaryComponent;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SalaryComponentTest extends TestCase
{
    use WithFaker;

    public function test_can_get_salary_components()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/salary-componentsall');
//        dd($response->getContent());
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_show_salary_component_details()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $salary_component = factory(SalaryComponent::class, 1)->create()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->get("/api/salary-components/{$salary_component->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_store_multiple_salary_components_at_once()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $salary_components = [
            [
                'name' => $this->faker->word . ' ' . time(),
                'order' => $this->faker->randomNumber(2),
                'type' => $this->faker->randomElement(['prime', 'indemnité', 'bonus', 'allocation']),
                'categorie' => $this->faker->word,
                'code' => $this->faker->word,
                'base_amount' => 5000,
                'coef' => 1,
                'coef_patronal' => 1,
                'base_patronal' => 5000,
            ]
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/salary-components', [
                'salary_components' => $salary_components
            ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_update_salary_component()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $salary_component = factory(SalaryComponent::class, 1)->create()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/salary-components/{$salary_component->id}", [
                'name' => $this->faker->word,
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_update_salary_component_order()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $salary_component = factory(SalaryComponent::class, 1)->create()->first();

        $newOrder = $this->faker->randomNumber(2);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/salary-components/{$salary_component->id}", [
                'order' => $newOrder,
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        // Verify the order was updated
        $salary_component->refresh();
        $this->assertEquals($newOrder, $salary_component->order);
    }

    public function test_can_trash_restore_delete_salary_components()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $salary_components = factory(SalaryComponent::class, 2)->create();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/salary-components/trash', [
                'ids' => $salary_components->pluck('id')->toArray()
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/salary-components/restore', [
                'ids' => $salary_components->pluck('id')->toArray()
            ])
            ->assertStatus(200);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/salary-components/delete', [
                'ids' => $salary_components->pluck('id')->toArray()
            ])
            ->assertStatus(200);
    }
}
