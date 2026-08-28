<?php

namespace Tests\Feature;

use App\Models\Assessment;
use App\Models\ExamStudent;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExamStudentTest extends TestCase
{
    use WithFaker;

    /**
     * Test pour récupérer tous les examens.
     */
    public function testCanGetAllExamStudents()
    {
        $login = parent::login([
            'username' => 'student',
            'password' => '000000',
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->post("/api/examsall", [
                'idSchool' => 1,
            ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    "id",
                    "idAssessment",
                    "idAssessmentType",
                    "idUser",
                    "statut",
                    "created_at",
                    "updated_at",
                    "updated_by",
                    "deleted_by",
                    "deleted",
                ],
            ],
            'links',
            'meta',
        ]);
    }

    /**
     * Test pour créer un examen.
     */
    public function testCanStartExam()
    {
        $login = parent::login([
            'username' => 'student',
            'password' => '000000',
        ]);

        $assessment = Assessment::join("assessments_has_assessment_type", "assessments_has_assessment_type.assessment_id", "=", "assessments.id")
            ->inRandomOrder()->first();

        $header = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
        ->post("/api/exams", [
            'idAssessment' => $assessment["assessment_id"],
            'idAssessmentType' => $assessment["assessment_type_id"],
        ])
        ->assertStatus(200)
        ->assertJson([
            'success' => true,
            'data' => [],
            'message' => "Début de l'examen",
        ]);

        $this->assertDatabaseHas("exam_students", [
            'idAssessment' => $assessment["assessment_id"],
            'idAssessmentType' => $assessment["assessment_type_id"],
            'idUser' => auth()->user()->id,
            'finished' => false,
        ]);
    }

    /**
     * Test pour récupérer un examen par son ID.
     */
    public function testCanGetSingleExam()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000',
        ]);

        // Créer un enregistrement pour le test
        $assessment = Assessment::join("assessments_has_assessment_type", "assessments_has_assessment_type.assessment_id", "=", "assessments.id")
            ->inRandomOrder()->first();

        $exam = ExamStudent::create([
            'idAssessment' => $assessment["assessment_id"],
            'idAssessmentType' => $assessment["assessment_type_id"],
            'idUser' => auth()->user()->id,
            'statut' => "valid",
            'finished' => false, // Ajoutez si nécessaire
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->get("/api/exams/{$exam->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    "id",
                    "idAssessment",
                    "idAssessmentType",
                    "idUser",
                    "statut",
                    "created_at",
                    "updated_at",
                    "updated_by",
                    "deleted_by",
                    "deleted",
                ],
            ]);
    }

    /**
     * Test pour supprimer un examen.
     */
    public function testCanTrashExam()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000',
        ]);

        $header = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token]);

        // Créer un enregistrement pour le test
        $exam = ExamStudent::create([
            'idAssessment' => 1, // Remplacez par des données valides
            'idAssessmentType' => 1, // Remplacez par des données valides
            'idUser' => 1, // Remplacez par un ID utilisateur valide
            'statut' => "valid",
            'finished' => false,
            'deleted' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $header->delete("/api/exams/trash/{$exam->id}")
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => "Examen étudiant supprimé avec succès.",
            ]);

        $this->assertDatabaseHas('exam_students', [
            'id' => $exam->id,
            'deleted' => true,
            'deleted_by' => json_decode($login->getContent())->data->id,
        ]);
    }

    /**
     * Test pour restaurer un examen.
     */
    public function testCanRestoreExam()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000',
        ]);

        $header = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token]);

        // Créer un enregistrement pour le test
        $exam = ExamStudent::create([
            'idAssessment' => 1, // Remplacez par des données valides
            'idAssessmentType' => 1, // Remplacez par des données valides
            'idUser' => 1, // Remplacez par un ID utilisateur valide
            'statut' => "valid",
            'finished' => false,
            'deleted' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $header->post("/api/exams/restore/{$exam->id}")
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => "Examen étudiant restauré avec succès.",
            ]);

        $this->assertDatabaseHas('exam_students', [
            'id' => $exam->id,
            'deleted' => false,
        ]);
    }
}
