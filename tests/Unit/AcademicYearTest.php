<?php

namespace Tests\Unit;

use App\Models\AcademicYear;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AcademicYearTest extends TestCase
{
    use WithFaker;

    public function test_can_get_academicyears()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/academic-yearsall')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_create_academicyear()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $startDate = Carbon::createFromFormat('Y-m-d', $this->faker->date('Y-m-d'));
        $endDate = $startDate->copy()->addMonths(9);

        $previousAcademicYear = AcademicYear::create([
            'name' => "test 2025",
            'start_date' => "2020-09-01",
            'end_date' => "2025-09-01"
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/academic-years', [
                'name' => $this->faker->name,
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
                'previousAcademicYearId' => $previousAcademicYear->id,
            ])
            ->assertStatus(201)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_non_admin_cannot_create_academicyear()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $startDate = Carbon::createFromFormat('Y-m-d', $this->faker->date('Y-m-d'));
        $endDate = $startDate->copy()->addMonths(9);

        $previousAcademicYear = AcademicYear::create([
            'name' => "test 2025",
            'start_date' => "2020-09-01",
            'end_date' => "2025-09-01"
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/academic-years', [
                'name' => $this->faker->name,
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
                'previousAcademicYearId' => $previousAcademicYear->id,
            ])
            ->assertStatus(403);
    }

    public function test_can_update_academicyear()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $academicyear = factory(AcademicYear::class)->create();

        $previousAcademicYear = AcademicYear::create([
            'name' => "test 2025",
            'start_date' => "2020-09-01",
            'end_date' => "2025-09-01"
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/academic-years/{$academicyear->id}", [
                'name' => $this->faker->name,
                'previousAcademicYearId' => $previousAcademicYear->id,
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        $academicyear->delete();
    }

    public function test_non_admin_cannot_update_academicyear()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $academicyear = factory(AcademicYear::class)->create();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/academic-years/{$academicyear->id}", [
                'name' => $this->faker->name
            ])
            ->assertStatus(403);

        $academicyear->delete();
    }

    public function test_can_delete_academicyear()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $academicyear = factory(AcademicYear::class)->create([
            'deleted' => true
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->delete("/api/academic-years/{$academicyear->id}")
            ->assertStatus(200);
    }
    public function test_cannot_delete_untrashed_academicyear()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $academicyear = factory(AcademicYear::class)->create([
            'deleted' => false
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->delete("/api/academic-years/{$academicyear->id}")
            ->assertStatus(404);
    }

    public function test_no_admin_cannot_delete_academicyear()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $academicyear = factory(AcademicYear::class)->create();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->delete("/api/academic-years/{$academicyear->id}")
            ->assertStatus(403);
    }

    public function test_can_trash_academicyears()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $academicyears = factory(AcademicYear::class, 3)->create();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/academic-years/trash", [
                'ids' => $academicyears->pluck('id')->toArray()
            ])
            ->assertStatus(200);

        $academicyears->each(function($academicyear) {
            $academicyear->delete();
        });
    }

    public function test_non_admin_cannot_trash_academicyears()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $academicyears = factory(AcademicYear::class, 3)->create();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/academic-years/trash", [
                'ids' => $academicyears->pluck('id')->toArray()
            ])
            ->assertStatus(403);

        $academicyears->each(function($academicyear) {
            $academicyear->delete();
        });
    }

    public function test_can_restore_academicyears()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $academicyears = factory(AcademicYear::class, 3)->create([
            'deleted' => true
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/academic-years/restore", [
                'ids' => $academicyears->pluck('id')->toArray()
            ])
            ->assertStatus(200);

        $academicyears->each(function($academicyear) {
            $academicyear->delete();
        });
    }

    public function test_non_admin_cannot_restore_academicyears()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $academicyears = factory(AcademicYear::class, 3)->create([
            'deleted' => true
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/academic-years/restore", [
                'ids' => $academicyears->pluck('id')->toArray()
            ])
            ->assertStatus(403);

        $academicyears->each(function($academicyear) {
            $academicyear->delete();
        });
    }

    // TODO: Tester aussi qu'on ne peut pas supprimer des ressources qui sont déjà liées à d'autres tables ...
}
