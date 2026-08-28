<?php

namespace Tests\Unit;

use App\Enums\StatusEnum;
use App\Models\Bonus;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BonusTest extends TestCase
{
    use WithFaker;

    public function test_can_list_bonuses(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/bonusesall')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data', 'sommes'
            ]);
    }

    public function test_can_create_bonuses()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $bonuses = [
            [
                'idUser' => User::inRandomOrder()->first()->id,
                'idUserApprove' => User::inRandomOrder()->first()->id,
                'bonus_type' => $this->faker->randomElement(['student', 'staff']),
                'amount' => rand(1000, 10000),
                'reason' => $this->faker->sentence,
            ],
            [
                'idUser' => User::inRandomOrder()->first()->id,
                'idUserApprove' => User::inRandomOrder()->first()->id,
                'bonus_type' => $this->faker->randomElement(['student', 'staff']),
                'amount' => rand(1000, 10000),
                'reason' => $this->faker->sentence,
            ],
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/bonuses', [
                'bonuses' => $bonuses
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_approver_cannot_be_same_as_user_on_bonuses_creation()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $user = User::inRandomOrder()->first()->id;

        $bonuses = [
            [
                'idUser' => $user,
                'idUserApprove' => $user,
                'bonus_type' => $this->faker->randomElement(['student', 'staff']),
                'amount' => rand(1000, 10000),
                'reason' => $this->faker->sentence,
            ],
            [
                'idUser' => User::inRandomOrder()->first()->id,
                'idUserApprove' => User::inRandomOrder()->first()->id,
                'bonus_type' => $this->faker->randomElement(['student', 'staff']),
                'amount' => rand(1000, 10000),
                'reason' => $this->faker->sentence,
            ],
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/bonuses', [
                'bonuses' => $bonuses
            ])
            ->assertStatus(422);
    }

    public function test_cannot_create_bonuses_if_not_staff()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $bonuses = [
            [
                'idUser' => User::inRandomOrder()->first()->id,
                'idUserApprove' => User::inRandomOrder()->first()->id,
                'bonus_type' => $this->faker->randomElement(['student', 'staff']),
                'amount' => rand(1000, 10000),
                'reason' => $this->faker->sentence,
            ]
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/bonuses', [
                'bonuses' => $bonuses
            ])
            ->assertStatus(403);
    }

    public function test_can_update_bonus()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $bonus = factory(Bonus::class)->create([
            'idUser' => auth()->user()->id,
            'status' => "pending_approval",
        ]);

        $new_amount = rand(1000, 10000);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/bonuses/{$bonus->id}", [
                'amount' => $new_amount,
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
            $this->assertDatabaseHas("bonuses", [
                'id' => $bonus["id"],
                'amount' => $new_amount
            ]);

        $bonus->delete();
    }

    public function test_cannot_update_an_approved_bonus()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $bonus = factory(Bonus::class)->create([
            'idUser' => auth()->user()->id,
            'status' => $this->faker()->randomElement([StatusEnum::APPROVED])
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/bonuses/{$bonus->id}", [
            ])
            ->assertStatus(403);

        $bonus->delete();
    }

    public function test_can_trash_bonuses()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $bonuses = factory(Bonus::class, 5)->create();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/bonuses/trash", [
                'idBonuses' => $bonuses->pluck('id')->toArray()
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        collect($bonuses)->each(function ($bonus) {
            $bonus->delete();
        });
    }

    public function test_can_restore_bonuses()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $bonuses = factory(Bonus::class, 5)->create([
            'deleted' => 1
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/bonuses/restore", [
                'idBonuses' => $bonuses->pluck('id')->toArray()
            ])
            ->assertStatus(200);

        collect($bonuses)->each(function ($bonus) {
            $bonus->delete();
        });
    }

    public function test_can_delete_bonuses()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $bonuses = factory(Bonus::class, 5)->create([
            'deleted' => 1
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/bonuses/delete", [
                'idBonuses' => $bonuses->pluck('id')->toArray()
            ])
            ->assertStatus(200);
    }
}
