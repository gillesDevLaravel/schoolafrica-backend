<?php

namespace Tests\Feature;

use App\Models\Assessment;
use App\Models\ExamStudent;
use App\Models\Questionnaire;
use App\Models\ResponseUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResponseStudentTest extends TestCase
{
    use WithFaker;

    public function testStudentCanSendResponse()
    {
        $login = Parent::login([
            "username" => "student",
            "password" => "000000",
        ]);

        $assessment = Assessment::join("assessments_has_assessment_type", "assessments_has_assessment_type.assessment_id", "=", "assessments.id")
            ->inRandomOrder()->first();

        $question = Questionnaire::create([
            'idAssessment' => $assessment["assessment_id"],
            'idAssessmentType' => $assessment["assessment_type_id"],
            'intitule' => "question test",
            'reponse' => null,
            'notemax' => null,
        ]);

        // Démarrer un examen
        $exam = ExamStudent::create([
            'idAssessment' => $assessment['assessment_id'],
            'idAssessmentType' => $assessment['assessment_type_id'],
            'idUser' => auth()->user()->id,
            'statut' => "valid",
            'finished' => false,
            'created_at' => now() // s'assurer que created_at est défini à l'heure actuelle
        ]);

        $header = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->post("/api/responses", [
                "idAssessment" => $assessment["assessment_id"],
                "idAssessmentType" => $assessment["assessment_type_id"],
                "responses" => [
                    [
                        "idQuestion" => $question["id"],
                        "response" => null
                    ],
                ]
            ]);

        $header->assertStatus(200);
    }

    public function testStudentCanSendResponseIfExamDontExist()
    {
        $login = Parent::login([
            "username" => "student",
            "password" => "000000",
        ]);

        $assessment = Assessment::join("assessments_has_assessment_type", "assessments_has_assessment_type.assessment_id", "=", "assessments.id")
        ->inRandomOrder()->first();

        ExamStudent::where('idAssessment', $assessment['assessment_id'])
        ->where('idAssessmentType', $assessment['assessment_type_id'])
        ->where('idUser', auth()->user()->id)
        ->delete();

        $header = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->post("/api/responses", [
                "idAssessment" => $assessment["assessment_id"],
                "idAssessmentType" => $assessment["assessment_type_id"],
                "responses" => []
            ]);

        $header->assertStatus(404);
        $header->assertJson([
            'success' => false,
            'message' => 'Réponse inacceptable car l\'examen n\'a pas été démarré dans les normes'
        ]);
    }

    // public function testStudentCanNotSendResponseIfTimeOver()
    // {
    //     $login = Parent::login([
    //         "username" => "student",
    //         "password" => "000000",
    //     ]);

    //     $assessment = Assessment::join("assessments_has_assessment_type", "assessments_has_assessment_type.assessment_id", "=", "assessments.id")
    //     ->inRandomOrder()->first();

    //     $question = Questionnaire::create([
    //         'idAssessment' => $assessment["assessment_id"],
    //         'idAssessmentType' => $assessment["assessment_type_id"],
    //         'intitule' => "question test",
    //         'reponse' => null,
    //         'notemax' => null,
    //     ]);

    //     // Démarrer un examen avec un created_at retardé pour simuler un temps dépassé
    //     $exam = ExamStudent::create([
    //         'idAssessment' => $assessment['assessment_id'],
    //         'idAssessmentType' => $assessment['assessment_type_id'],
    //         'idUser' => auth()->user()->id,
    //         'statut' => true,
    //         'finished' => false,
    //         'created_at' => now()->subMinutes($assessment->duration + 200) // définir created_at pour dépasser la durée
    //     ]);

    //     $header = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
    //         ->post("/api/responses", [
    //             "idAssessment" => $assessment["assessment_id"],
    //             "idAssessmentType" => $assessment["assessment_type_id"],
    //             "responses" => [
    //                 [
    //                     "idQuestion" => $question["id"],
    //                     "response" => "test"
    //                 ],
    //             ]
    //         ]);

    //     dd($header->getContent());

    //     $header->assertStatus(404);
    //     $header->assertJson([
    //         'success' => false,
    //         'message' => 'Réponse inacceptable car vous avez dépassé la durée de cette évaluation'
    //     ]);
    // }


    public function testCanTrashResponse()
    {
        $login = Parent::login([
            "username" => "fondateur", // Assurez-vous que l'utilisateur a le rôle requis
            "password" => "000000",
        ]);

        $responseUser = ResponseUser::create([
            'idUser' => auth()->user()->id,
            'idQuestionnaire' => 1, // Utilisez un ID de questionnaire valide
            'idAssessment' => 1, // Utilisez un ID d'évaluation valide
            'response' => 'test response',
            'statut' => true,
        ]);

        $header = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->delete("/api/responses/trash/{$responseUser->id}");

        $header->assertStatus(200);
        $header->assertJson([
            'success' => true,
            'message' => 'Réponse supprimée.'
        ]);

        $this->assertDatabaseHas('response_users', [
            'id' => $responseUser->id,
            'deleted' => true,
            'deleted_by' => auth()->user()->id,
        ]);
    }


    public function testCanRestoreResponse()
    {
        $login = Parent::login([
            "username" => "fondateur", // Assurez-vous que l'utilisateur a le rôle requis
            "password" => "000000",
        ]);

        // Créer une réponse et la marquer comme supprimée
        $responseUser = ResponseUser::create([
            'idUser' => auth()->user()->id,
            'idQuestionnaire' => 1, // Utilisez un ID de questionnaire valide
            'idAssessment' => 1, // Utilisez un ID d'évaluation valide
            'response' => 'test response',
            'statut' => true,
            'deleted' => true,
            'deleted_by' => auth()->user()->id,
        ]);

        // Appeler la méthode restore
        $header = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->post("/api/responses/restore/{$responseUser->id}");

        // Vérifier la réponse
        $header->assertStatus(200);
        $header->assertJson([
            'success' => true,
            'message' => 'Réponse restaurée avec succès.'
        ]);

        // Vérifier que la réponse a été restaurée dans la base de données
        $this->assertDatabaseHas('response_users', [
            'id' => $responseUser->id,
            'deleted' => false,
        ]);
    }
}
