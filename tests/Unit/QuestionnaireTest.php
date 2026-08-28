<?php

namespace Tests\Unit;

use App\Models\Assessment;
use App\Models\AssessmentType;
use App\Models\Questionnaire;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QuestionnaireTest extends TestCase
{
    use WithFaker;

    public function testCanGetQuestionnaire(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/questionnairesall', [
//                'idAssessment' => 2,
//                'idAssessmentType' => 2,
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanStoreQuestionnaire(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $a = Assessment::latest()->first();
        $at = AssessmentType::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/questionnaires', [
                'idAssessment' => $a->id,
                'idAssessmentType' => $at->id,
                'intitule' => "faker words",
                'reponse' => "faker words"
            ])
            ->assertStatus(201)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanUpdateQuestionnaire(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $question = Questionnaire::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/questionnaires/{$question->id}", [
                'idAssessment' => 2,
                'idAssessmentType' => 2,
                'intitule' => $this->faker->sentence(15),
                'reponse' => $this->faker->sentence(15)
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanTrashQuestionnaire(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $question = Questionnaire::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->delete("/api/questionnaires/trash/{$question->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        $question->update([
            'deleted' => false,
            'deleted_by' => null
        ]);
    }
}
