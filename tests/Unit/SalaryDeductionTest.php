<?php

namespace Tests\Unit;

use App\Enums\StatusEnum;
use App\Models\SalaryDeduction;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SalaryDeductionTest extends TestCase
{
    use WithFaker;

    public function test_can_get_salary_deductions()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/salaries-deductionsall')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_show_salary_deduction_details()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $salary_deduction = factory(SalaryDeduction::class, 1)->create()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->get("/api/salaries-deductions/{$salary_deduction->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_store_multiple_salary_deductions_at_once()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $salary_deductions = [
            [
                'idUser' => User::inRandomOrder()->first()->id,
                'idUserApprove' => User::inRandomOrder()->first()->id,
                'reason' => $this->faker->sentence,
                'date' => $this->faker->date('Y-m-d'),
                'status' => StatusEnum::APPROVED,
                'amount' => 5000
            ]
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/salaries-deductions', [
                'salary_deductions' => $salary_deductions
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_trash_multiple_salary_deductions()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $salary_deductions = factory(SalaryDeduction::class, 3)->create();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/salaries-deductions/trash', [
                'idSalaryDeductions' => $salary_deductions->pluck('id')->toArray()
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        $salary_deductions->each(function ($salary_deduction) {
            $salary_deduction->delete();
        });
    }

    public function test_can_restore_multiple_salary_deductions()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $salary_deductions = factory(SalaryDeduction::class, 3)->create([
            'deleted' => 1
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/salaries-deductions/restore', [
                'idSalaryDeductions' => $salary_deductions->pluck('id')->toArray()
            ])
            ->assertStatus(200);

        $salary_deductions->each(function ($salary_deduction) {
            $salary_deduction->delete();
        });
    }

    public function test_can_delete_multiple_salary_deductions()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $salary_deductions = factory(SalaryDeduction::class, 3)->create([
            'deleted' => 1
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/salaries-deductions/delete', [
                'idSalaryDeductions' => $salary_deductions->pluck('id')->toArray()
            ])
            ->assertStatus(200);

        $salary_deductions->each(function ($salary_deduction) {
            $salary_deduction->delete();
        });
    }
}
