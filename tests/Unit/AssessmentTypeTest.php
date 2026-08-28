<?php

namespace Tests\Unit;

use App\Models\AssessmentType;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssessmentTypeTest extends TestCase
{
    use WithFaker;

    public function testCanGetAssessmentTypes(){
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/assessmenttypesall', [
                'idSchool' => 2
            ]);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanCreateAssessmentType()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $startDate = $this->faker->date();
        $endDate = $this->faker->dateTimeBetween($startDate, '+1 year')->format('Y-m-d');

        $at = [
            [
                'name' => $this->faker->name,
                'numbering' => $this->faker->numberBetween(1, 9),
                'idTrimestre' => 2,
                'takenIntoAccount' => $this->faker->boolean,
                'notes_completed' => $this->faker->boolean,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/assessmenttypes', [
                'assessmenttypes' => $at
            ]);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanUpdateAssessmentType()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $at = AssessmentType::latest()->first();
        $newNumbering = $this->faker->numberBetween(1, 9);
        $newNotesCompleted = $this->faker->boolean;
        $newStartDate = $this->faker->date();
        $newEndDate = $this->faker->dateTimeBetween($newStartDate, '+1 year')->format('Y-m-d');

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/assessmenttypes/{$at->id}", [
                'numbering' => $newNumbering,
                'notes_completed' => $newNotesCompleted,
                'start_date' => $newStartDate,
                'end_date' => $newEndDate
            ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ])
            ->assertJson([
                'data' => [
                    'numbering' => $newNumbering,
                    'notes_completed' => $newNotesCompleted,
                    'start_date' => Carbon::parse($newStartDate)->toISOString(),
                    'end_date' => Carbon::parse($newEndDate)->toISOString()
                ]
            ]);
    }


    public function testCanDeleteAssessmentType()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $at = AssessmentType::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->deleteJson("/api/assessmenttypes/{$at->id}")
            ->assertStatus(200);

        $at->update([
            'deleted' => false
        ]);
    }
}
