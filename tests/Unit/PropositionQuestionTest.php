<?php

namespace Tests\Unit;

use App\Models\Assessment;
use App\Models\AssessmentType;
use App\Models\PropositionQuestion;
use App\Models\Questionnaire;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PropositionQuestionTest extends TestCase
{
    use WithFaker;

    public function testCanGetPropositionQuestionnaire(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $questionnaire = Questionnaire::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/propositions-questionnairesall', [
                'idQuestion' => $questionnaire->id
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCannotGetPropositionQuestionnaireWithoutidQuestionnaire(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $questionnaire = Questionnaire::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/propositions-questionnairesall', [

            ])
            ->assertStatus(422);
    }

    public function testCanStoreQuestionnaire(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $questionnaire = Questionnaire::latest()->first();

        $propositions = [
            'idQuestion' => $questionnaire->id,
            'propositions' => [
                [
                    'intitule' => $this->faker->word,
                    'is_correct' => $this->faker->boolean,
                ],
                [
                    'intitule' => $this->faker->word,
                    'is_correct' => $this->faker->boolean,
                ],
                [
                    'intitule' => $this->faker->word,
                    'is_correct' => $this->faker->boolean,
                ]
            ],
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/propositions-questionnaires', $propositions)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testStudentCannotStoreQuestionnaire(){
        $login = parent::login([
            'username' => 'toto',
            'password' => '000000'
        ]);

        $questionnaire = Questionnaire::latest()->first();
        $propositions = [
            'idQuestion' => $questionnaire->id,
            'propositions' => [
                [
                    'intitule' => $this->faker->word,
                    'is_correct' => $this->faker->boolean,
                ]
            ],
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/propositions-questionnaires', $propositions)
            ->assertStatus(403);
    }

    public function testCanUpdateQuestionnaire(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $proposition_question = PropositionQuestion::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/propositions-questionnaires/{$proposition_question->id}", [
                'intitule' => $this->faker->sentence(5),
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testStudentCannotUpdateQuestionnaire(){
        $login = parent::login([
            'username' => 'toto',
            'password' => '000000'
        ]);

        $proposition_question = PropositionQuestion::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/propositions-questionnaires/{$proposition_question->id}", [
                'intitule' => $this->faker->sentence(5),
            ])
            ->assertStatus(403);
    }

    public function testCanTrashQuestionnaire(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $proposition_question = PropositionQuestion::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->delete("/api/propositions-questionnaires/trash/{$proposition_question->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        $proposition_question->update([
            'deleted' => false,
            'deleted_by' => null
        ]);
    }

    public function testStudentCannotTrashQuestionnaire(){
        $login = parent::login([
            'username' => 'toto',
            'password' => '000000'
        ]);

        $proposition_question = PropositionQuestion::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->delete("/api/propositions-questionnaires/trash/{$proposition_question->id}")
            ->assertStatus(403);
    }
}
