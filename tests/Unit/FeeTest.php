<?php

namespace Tests\Unit;

use App\Models\Fee;
use App\Models\TypeOfRecipe;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FeeTest extends TestCase
{
    use WithFaker;

    public function testCanGetFees()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/feesall", [
                'idSchool' => 1
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanCreateFee()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/fees", [
                'name' => $this->faker->name,
                'description' => $this->faker->text,
                'price' => 80000,
                'deadline' => "2025-04-01",
                'order' => $this->faker->numberBetween(1, 5),
                'required' => $this->faker->randomElement([true, false]),
                'idSchool' => 2,
                'idTypeOfRecipe' => factory(TypeOfRecipe::class)->create()->id,
//                'idSection' => 2,
            ])
            ->assertStatus(201);
    }

    public function testCanDeleteFee()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $fee = Fee::create([
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'price' => 80000,
            'deadline' => "2025-04-01",
            'idSchool' => 2,
            'idSection' => 2,
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->delete("/api/fees/{$fee->id}")
            ->assertStatus(200);

        $fee->update([
            'deleted' => false
        ]);
    }
}
