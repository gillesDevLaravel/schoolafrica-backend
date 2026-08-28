<?php

namespace Tests\Unit\Documents;

use App\Models\Assessment;
use App\Models\AssessmentType;
use App\Models\Classes;
use App\Models\ExamStudent;
use App\Models\Matter;
use App\Models\Questionnaire;
use App\Models\ResponseUser;
use App\Models\Section;
use App\Models\User;
use App\Traits\ManageDirectoryTrait;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PDFListStudentAnswersOnAssessmentTest extends TestCase
{
    use WithFaker;
    use ManageDirectoryTrait;

    public function test_can_generate_pdf_of_questions_answers_for_student()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $classe = Classes::inRandomOrder()->first();
        $section = Section::find($classe->idSection);

        $student = User::create([
            'name' =>  $this->faker->name,
            'email' =>  $this->faker->email,
            'username' => "fake_username",
            'gender' => "male",
            'matricule' => User::generateMatricule("TST", "2025", strtoupper(substr($section->name, 0, 3))),
            'password' =>  bcrypt('000000'),
            'idClasse' => $classe->id,
            'idSchool' => $classe->idSchool,
            'idSection' => $classe->idSection,
        ]);

        $assessment = Assessment::inRandomOrder()->first();
        $assessmentType = AssessmentType::inRandomOrder()->first();

        $exam = ExamStudent::create([
            'idAssessment' => $assessment->id,
            'idAssessmentType' => $assessmentType->id,
            'idUser' => $student->id,
            'statut' => 'valid',
        ]);

        $questions = array();
        for ($i = 0; $i<10; $i++) {
            $questions[] = Questionnaire::create([
                'idAssessment' => $assessment->id,
                'idAssessmentType' => $assessmentType->id,
                'intitule' =>  $this->faker->sentence(),
                'notemax' => rand(1,3)
            ]);
        }

        $response_users = array();

        foreach ($questions as $question) {
            $response_users[] = ResponseUser::create([
                'idUser' => $student->id,
                'idQuestionnaire' => $question->id,
                'idAssessment' => $assessment->id,
                'response' => $this->faker->sentence(),
            ]);
        }


        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/documents/list-student-answers-on-assessment', [
                'idStudent' => $student->id,
                'idAssessmentType' => $assessmentType->id
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'success',
                'message',
            ]);

        // On vérifie que le fichier ZIP est bien généré
        $this->assertMatchesRegularExpression(
            '/^https?:\/\/.+\.(zip|pdf)$/',
            $response->json('data')
        );

        // on supprime les éléments qu'on a ajouté
        $student->delete();
        $exam->delete();
        collect($questions)->each(function ($question) {
            $question->delete();
        });
        collect($response_users)->each(function ($response) {
            $response->delete();
        });
    }
}
