<?php

namespace Tests\Unit;

use App\Models\Bourse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BourseTest extends TestCase
{
    use WithFaker;

    public function testCanGetBourses(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/boursesall', [
                'idSchool' => 2
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanCreateBourse()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $bourses = [
            [
                'name' => $this->faker->name,
                'description' => $this->faker->text(45),
                'amount' => rand(1000,9999),
                'idSchool' => 2
            ]
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/bourses', [
                'bourses' => $bourses
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanUpdateBourse()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $bo = Bourse::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/bourses/{$bo->id}", [
                'name' => $this->faker->name,
                'description' => $this->faker->text(10),
                'amount' => rand(1000,9999),
                'idSchool' => 2,
                'idSection' => 2
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanDeleteBourse()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $bo = Bourse::latest()->first();

        if(!is_null($bo)){
            $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
                ->deleteJson("/api/bourses/{$bo->id}")
                ->assertStatus(200);
        }
    }
}
