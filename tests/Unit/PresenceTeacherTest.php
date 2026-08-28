<?php

namespace Tests\Unit;

use App\Models\PresenceTeacher;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PresenceTeacherTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_archive_presence_teachers()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $presenceOne = $this->createPresenceTeacherForArchive();
        $presenceTwo = $this->createPresenceTeacherForArchive();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/presenceteachers/trash', ['ids' => [$presenceOne->id, $presenceTwo->id]])
            ->assertStatus(204);

        $this->assertSoftDeleted('presence_teacher', ['id' => $presenceOne->id]);
        $this->assertSoftDeleted('presence_teacher', ['id' => $presenceTwo->id]);
    }

    public function test_can_restore_presence_teachers()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $presenceOne = $this->createPresenceTeacherForArchive();
        $presenceTwo = $this->createPresenceTeacherForArchive();

        $presenceOne->delete();
        $presenceTwo->delete();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/presenceteachers/restore', ['ids' => [$presenceOne->id, $presenceTwo->id]])
            ->assertStatus(200)
            ->assertJsonFragment([
                'success' => true,
                'message' => __('presenceteacher.restore.success'),
            ]);

        $this->assertDatabaseHas('presence_teacher', ['id' => $presenceOne->id, 'deleted_at' => null]);
        $this->assertDatabaseHas('presence_teacher', ['id' => $presenceTwo->id, 'deleted_at' => null]);
    }

    public function test_can_delete_presence_teachers_permanently()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $presenceOne = $this->createPresenceTeacherForArchive();
        $presenceTwo = $this->createPresenceTeacherForArchive();

        $presenceOne->delete();
        $presenceTwo->delete();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/presenceteachers/delete', ['ids' => [$presenceOne->id, $presenceTwo->id]])
            ->assertStatus(204);

        $this->assertDatabaseMissing('presence_teacher', ['id' => $presenceOne->id]);
        $this->assertDatabaseMissing('presence_teacher', ['id' => $presenceTwo->id]);
    }

    private function createPresenceTeacherForArchive()
    {
        $teacher = User::whereNotNull('idSchool')->first() ?? User::inRandomOrder()->first();

        if (!$teacher) {
            $this->markTestSkipped('Aucun enseignant disponible pour créer une présence.');
        }

        return PresenceTeacher::create([
            'idTeacher' => $teacher->id,
            'date' => now()->toDateString(),
            'hour' => now()->format('H:i:s'),
            'arrivalTime' => now()->format('H:i:s'),
            'departureTime' => now()->addHour()->format('H:i:s'),
            'idSchool' => $teacher->idSchool ?? null,
            'idSection' => $teacher->idSection ?? null,
            'created_by' => $teacher->id,
        ]);
    }
}
