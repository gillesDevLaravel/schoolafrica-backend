<?php

namespace Tests\Unit;

use App\Enums\StatusEnum;
use App\Models\SalaryAdvance;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SalaryAdvanceTest extends TestCase
{
    use WithFaker;

    public function test_can_list_salary_advances(){
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/salary-advancesall')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_create_salary_advances()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $salary_advance_details = [
            [
                'reason' => $this->faker->text,
                'amount' => $this->faker->randomFloat(0, 10),
                'idUserApprove' => User::inRandomOrder()->first()->id,
            ]
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/salary-advances', [
                'salary_advances' => $salary_advance_details
            ])
            ->assertStatus(201)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_update_salary_advance()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $salary_advance = factory(SalaryAdvance::class)->create([
            'idUser' => auth()->user()->id
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/salary-advances/{$salary_advance->id}", [
                'amoun' => $this->faker()->randomFloat(0, 10),
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        $salary_advance->delete();
    }

    public function test_cannot_update_an_approved_salary_advance()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $salary_advance = factory(SalaryAdvance::class)->create([
            'idUser' => auth()->user()->id,
            'status' => StatusEnum::APPROVED
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/salary_advances/{$salary_advance->id}", [
                'days_taken' => rand(1,5),
            ])
            ->assertStatus(404);

        $salary_advance->delete();
    }

    public function test_can_trash_salary_advances()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $salary_advances = factory(SalaryAdvance::class, 5)->create();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/salary-advances/trash", [
                'ids' => $salary_advances->pluck('id')->toArray()
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        collect($salary_advances)->each(function ($salary_advance) {
            $salary_advance->delete();
        });
    }

    public function test_can_restore_salary_advances()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $salary_advances = factory(SalaryAdvance::class, 5)->create([
            'deleted' => 1
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/salary-advances/restore", [
                'ids' => $salary_advances->pluck('id')->toArray()
            ])
            ->assertStatus(200);

        collect($salary_advances)->each(function ($salary_advance) {
            $salary_advance->delete();
        });
    }

    public function test_can_delete_salary_advances()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $salary_advances = factory(SalaryAdvance::class, 5)->create([
            'deleted' => 1
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/salary-advances/delete", [
                'ids' => $salary_advances->pluck('id')->toArray()
            ])
            ->assertStatus(200);
    }
}
