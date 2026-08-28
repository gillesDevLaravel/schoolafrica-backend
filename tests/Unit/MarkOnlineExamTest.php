<?php

namespace Tests\Unit;

use App\Models\Questionnaire;
use App\Models\ResponseUser;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MarkOnlineExamTest extends TestCase
{
    use WithFaker;

    public function testTeacherCanGetStudentAnswersToOnlineExam()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/mark-exam-online/get-student-responses', [
                'idUser' => 22,
                'idAssessment' => 90,
                'idAssessmentType' => 9,
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testStudentCannotGetStudentAnswersToOnlineExam()
    {
        $login = parent::login([
            'username' => 'toto',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/mark-exam-online/get-student-responses', [
                'idUser' => 22,
                'idAssessment' => 90,
                'idAssessmentType' => 9,
            ])
            ->assertStatus(403);
    }

    public function testTeacherCanMarkOnlineExam()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $q = Questionnaire::create([
            'idAssessment' => 90,
            'idAssessmentType' => 9,
            'intitule' => $this->faker->word,
            'reponse' => $this->faker->word,
            'notemax' => $this->faker->randomNumber(),
        ]);
        $r_u = ResponseUser::create([
            'idUser' => 22,
            'idAssessment' => 90,
            'idQuestionnaire' => 9,
            'response' => $this->faker->word,
//            'note' => rand(1,5)
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/mark-exam-online/set-student-notes', [
                'idUser' => 22,
                'idAssessment' => 90,
                'idAssessmentType' => 9,
                'notes' => [
                    [
                        'idQuestionnaire' => $q->id,
                        'idResponseUser' => $r_u->id,
                        'note' => $this->faker->randomNumber()
                    ],
                ]
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testStudentCannotMarkOnlineExam()
    {
        $login = parent::login([
            'username' => 'toto',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/mark-exam-online/set-student-notes', [
                'idUser' => 22,
                'idAssessment' => 90,
                'idAssessmentType' => 9,
                'notes' => [
                    [
                        'idQuestionnaire' => 1,
                        'idResponseUser' => 1,
                        'note' => $this->faker->randomNumber()
                    ],
                ]
            ])
            ->assertStatus(403);
    }
}
