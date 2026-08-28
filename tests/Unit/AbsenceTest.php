<?php

namespace Tests\Unit;

use App\Models\Absence;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AbsenceTest extends TestCase
{
    use DatabaseTransactions;

    public function testCanListAbsences()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/absencesall', [
                'idSchool' => 2,
                'idSection' => 2,
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'links',
                'meta',
            ]);
    }

    public function testCanCreateAbsence()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $absences = [
            [
                'image' => "student",
                'type' => "student",
                'date' => "2024-09-30",
                'justification' => "test de justification",
                'idCourse' => Course::where('idClasse', 10)->first()->id,
                'idStudent' => 927,
            ]
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/absences', [
                'absences' => $absences,
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'success',
                'message',
            ]);
    }

    public function testCanUpdateAbsence()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $absence = Absence::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/absences/{$absence->id}", [
                'type' => "student",
                'date' => "2024-09-30",
                'idCourse' => Course::where('idClasse', 10)->first()->id,
                'idStudent' => 927,
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
            ]);
    }

    public function test_can_archive_absences()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $absenceOne = $this->createAbsenceForArchive();
        $absenceTwo = $this->createAbsenceForArchive();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/absences/trash', ['ids' => [$absenceOne->id, $absenceTwo->id]])
            ->assertStatus(204);

        $this->assertSoftDeleted('absences', ['id' => $absenceOne->id]);
        $this->assertSoftDeleted('absences', ['id' => $absenceTwo->id]);
    }

    public function test_can_restore_absences()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $absenceOne = $this->createAbsenceForArchive();
        $absenceTwo = $this->createAbsenceForArchive();

        $absenceOne->delete();
        $absenceTwo->delete();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/absences/restore', ['ids' => [$absenceOne->id, $absenceTwo->id]])
            ->assertStatus(200)
            ->assertJsonFragment([
                'success' => true,
                'message' => __('absence.restore.success'),
            ]);

        $this->assertDatabaseHas('absences', ['id' => $absenceOne->id, 'deleted_at' => null]);
        $this->assertDatabaseHas('absences', ['id' => $absenceTwo->id, 'deleted_at' => null]);
    }

    public function test_can_delete_absences_permanently()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $absenceOne = $this->createAbsenceForArchive();
        $absenceTwo = $this->createAbsenceForArchive();

        $absenceOne->delete();
        $absenceTwo->delete();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/absences/delete', ['ids' => [$absenceOne->id, $absenceTwo->id]])
            ->assertStatus(204);

        $this->assertDatabaseMissing('absences', ['id' => $absenceOne->id]);
        $this->assertDatabaseMissing('absences', ['id' => $absenceTwo->id]);
    }

    private function createAbsenceForArchive()
    {
        $student = User::find($this->idStudent) ?? User::inRandomOrder()->first();
        $course = Course::whereNotNull('idSchool')->first();

        if (!$student || !$course) {
            $this->markTestSkipped('Aucun étudiant ou cours valide trouvé pour créer une absence.');
        }

        return Absence::create([
            'type' => 'student',
            'date' => now()->toDateString(),
            'idCourse' => $course->id,
            'is_justified' => false,
            'idTeacher' => $course->idTeacher,
            'idStudent' => $student->id,
            'idSchool' => $student->idSchool ?? $course->idSchool,
            'idSection' => $student->idSection ?? $course->idSection,
            'created_by' => $student->id,
        ]);
    }
}
