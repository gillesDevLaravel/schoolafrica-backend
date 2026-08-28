<?php

namespace Tests\Unit;

use App\Models\Course;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CoursTest extends TestCase
{
    use WithFaker;
    use DatabaseTransactions;

    public function testCanGetAllCours()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/coursesall', [
                "idSchool" => 2
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'links',
                'meta',
            ]);
    }

    public function testCanDuplicateCourses()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/coursesduplicate', [
                'idClasse' => 10,
                'idTeacher' => 171,
                'cours_id' => [1,2,3]
            ]);

            $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
                'message',
            ]);
    }

    public function testCanCreateCours()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/courses', [
                'idClasse' => 10,
                'idTeacher' => 171,
                'hour' => "10:01",
                'day' => "Sunday",
                'duration' => 59,
                'idMatter' => 1,
                'idSchool' => 2,
                'idPiece' => 2
            ])
            ->assertStatus(201)
            ->assertJsonStructure([
                'data',
            ]);
    }

    public function testCanUpdateCours()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $cours = Course::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/courses/{$cours->id}", [
                'idClasse' => 10
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
            ]);
    }

    public function testCanDeleteCours()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $cours = Course::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->deleteJson("/api/courses/{$cours->id}", [
                'idClasse' => 10
            ])
            ->assertStatus(200);
    }

    public function test_can_archive_courses()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        list($courseOne, $courseTwo) = $this->getTwoCoursesForArchive();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/courses/trash', ['ids' => [$courseOne->id, $courseTwo->id]])
            ->assertStatus(204);

        $this->assertSoftDeleted('courses', ['id' => $courseOne->id]);
        $this->assertSoftDeleted('courses', ['id' => $courseTwo->id]);
    }

    public function test_can_restore_courses()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        list($courseOne, $courseTwo) = $this->getTwoCoursesForArchive();

        $courseOne->delete();
        $courseTwo->delete();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/courses/restore', ['ids' => [$courseOne->id, $courseTwo->id]])
            ->assertStatus(200)
            ->assertJsonFragment([
                'success' => true,
                'message' => __('course.restore.success'),
            ]);

        $this->assertDatabaseHas('courses', ['id' => $courseOne->id, 'deleted_at' => null]);
        $this->assertDatabaseHas('courses', ['id' => $courseTwo->id, 'deleted_at' => null]);
    }

    public function test_can_delete_courses_permanently()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        list($courseOne, $courseTwo) = $this->getTwoCoursesForArchive();

        $courseOne->delete();
        $courseTwo->delete();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/courses/delete', ['ids' => [$courseOne->id, $courseTwo->id]])
            ->assertStatus(204);

        $this->assertDatabaseMissing('courses', ['id' => $courseOne->id]);
        $this->assertDatabaseMissing('courses', ['id' => $courseTwo->id]);
    }

    private function getTwoCoursesForArchive()
    {
        $courses = Course::take(2)->get();

        if ($courses->count() >= 2) {
            return [$courses[0], $courses[1]];
        }

        $baseCourse = Course::first();

        if (!$baseCourse) {
            $this->markTestSkipped('Aucun cours disponible pour tester l\'archivage multiple.');
        }

        $createdCourse = Course::create([
            'hour' => now()->format('H:i:s'),
            'duration' => $baseCourse->duration,
            'day' => $baseCourse->day,
            'date' => $baseCourse->date,
            'document' => $baseCourse->document,
            'idMatter' => $baseCourse->idMatter,
            'idClasse' => $baseCourse->idClasse,
            'idTeacher' => $baseCourse->idTeacher,
            'idSchool' => $baseCourse->idSchool,
            'idSection' => $baseCourse->idSection,
            'idLevel' => $baseCourse->idLevel,
            'idPiece' => $baseCourse->idPiece ?? null,
            'created_by' => $baseCourse->created_by,
        ]);

        return [$baseCourse, $createdCourse];
    }
}
