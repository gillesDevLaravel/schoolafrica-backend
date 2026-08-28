<?php

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use WithFaker;

    public function test_can_list_products(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/productsall')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_create_products()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $types = ['consommable', 'stockable'];
        $products = array();

        for ($i =0; $i < rand(3,6); $i++) {
            $products[] = [
                'name'  => $this->faker->name,
                'description'  => $this->faker->sentence,
                'price'  => rand(1000, 150000),
                'type'  => $this->faker->randomElement($types),
            ];
        }

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/products', [
                'products' => $products,
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_update_product()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $types = ['consommable', 'stockable'];
        $product = Product::inRandomOrder()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/products/{$product->id}", [
                'name'  => $this->faker->name,
                'description'  => $this->faker->sentence,
                'price'  => rand(1000, 150000),
                'type'  => $this->faker->randomElement($types),
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_trash_products()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $products = factory(Product::class, 5)->create();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/products/trash", [
                'idProducts' => $products->pluck('id')->toArray()
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        collect($products)->each(function ($product) {
            $product->delete();
        });
    }

    public function test_can_restore_products()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $products = factory(Product::class, 5)->create([
            'deleted' => 1
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/products/restore", [
                'idProducts' => $products->pluck('id')->toArray()
            ])
            ->assertStatus(200);

        collect($products)->each(function ($product) {
            $product->delete();
        });
    }

    public function test_can_delete_products()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $products = factory(Product::class, 5)->create([
            'deleted' => 1
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/products/delete", [
                'idProducts' => $products->pluck('id')->toArray()
            ])
            ->assertStatus(200);
    }
}
