<?php

namespace Tests\Unit;

use App\Models\Assessment;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssessmentTest extends TestCase
{
    use WithFaker;

    public function testCanGetAssessments(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/assessmentsall', [
//                'idSchool' => 2,
                'idClasse' => 1
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'links',
                'meta'
            ]);
    }

    public function testCanCreateAssessment()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $assess = [
            [
                'idMatter' => 1,
//                'idTeacher' => 171,
                'idClasse' => 10,
                'duration' => rand(45,60),
                'notemax' => 20,
                'assessmentTypes' => [1,4,5,2]
            ]
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/assessments', [
                'assessments' => $assess
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
                'message',
            ]);
    }

    public function testCanDuplicateAssessments()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/assessmentsduplicate', [
                'idClasse' => 10,
                'idTeacher' => 171,
                'assessments_id' => [1,3,2]
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
                'message',
            ]);
    }

    public function testCanUpdateAssessment()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson('/api/assessments/37', [
                'idMatter' => 1,
                'idTeacher' => 171,
                'idClasse' => 10,
                'duration' => rand(45,60),
                'notemax' => 20,
                'libelle' => "Je testeuh le libellé"
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanDeleteAssessment()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $assessment = Assessment::orderBy('id', 'DESC')->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->delete("/api/assessments/{$assessment->id}")
            ->assertStatus(200);

        $assessment->update([
            'deleted' => false
        ]);
    }
}
