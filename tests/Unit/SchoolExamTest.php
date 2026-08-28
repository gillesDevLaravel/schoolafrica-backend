<?php

namespace Tests\Unit;

use App\Models\SchoolExam;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SchoolExamTest extends TestCase
{
    use WithFaker;
    use DatabaseTransactions;

    public function test_can_list_school_exams_with_filters_and_pagination()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        factory(SchoolExam::class, 5)->create([
            'idAssessmentType' => 1,
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/schools-examsall');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                    'id',
                    'name',
                    'image',
                    'idOptionLevel',
                    'idMatter',
                    'idAssessmentType',
                    'created_at',
                    'updated_at',
                    ],
                ],
                'links',
                'meta',
            ]);
    }

    public function test_can_create_multiple_school_exams()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $data = [
            'exams' => [
                [
                    'name' => $this->faker->words(3, true),
                    'image' => $this->faker->imageUrl(),
                    'idOptionLevel' => 1,   
                    'idMatter' => 2,
                    'idAssessmentType' => 1,
                ],
                [
                    'name' => $this->faker->words(3, true),
                    'image' => $this->faker->imageUrl(),
                    'idMatter' => 3,
                    'idAssessmentType' => 2,
                ],
            ]
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/schools-exams', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        foreach ($data['exams'] as $exam) {
            $this->assertDatabaseHas('schools_exams', [
                'name' => $exam['name'],
                'image' => $exam['image'],
                'idOptionLevel' => $exam['idOptionLevel'],
                'idMatter' => $exam['idMatter'],
                'idAssessmentType' => $exam['idAssessmentType'],
            ]);
        }
    }

    public function test_can_show_school_exam()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(SchoolExam::class)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->getJson("/api/schools-exams/{$record->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $record->id,
                    'name' => $record->name,
                    'image' => $record->image,
                    'idOptionLevel' => $record->idOptionLevel,
                    'idMatter' => $record->idMatter,
                    'idAssessmentType' => $record->idAssessmentType,
                ]
            ]);
    }

    public function test_can_update_school_exam()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(SchoolExam::class)->create([
            'idAssessmentType' => 1,
        ]);

        $updateData = [
            'name' => 'Examen mis à jour',
            'image' => $this->faker->imageUrl(),
            'idOptionLevel' => 1,
            'idMatter' => 2,
            'idAssessmentType' => 3,
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->putJson("/api/schools-exams/{$record->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'name' => $updateData['name'],
                    'image' => $updateData['image'],
                    'idAssessmentType' => $updateData['idAssessmentType'],
                ]
            ]);

        $this->assertDatabaseHas('schools_exams', [
            'id' => $record->id,
            'name' => 'Examen mis à jour',
            'image' => $updateData['image'],
            'idOptionLevel' => 1,
            'idMatter' => 2,
            'idAssessmentType' => 3,
        ]);
    }

    public function test_can_archive_school_exam()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(SchoolExam::class)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/schools-exams/trash', ['ids' => [$record->id]]);

        $response->assertStatus(204);
        $this->assertSoftDeleted('schools_exams', ['id' => $record->id]);
    }

    public function test_can_restore_school_exam()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(SchoolExam::class)->create();
        $record->delete();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/schools-exams/restore', ['ids' => [$record->id]]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'success' => true,
            ]);

        $this->assertDatabaseHas('schools_exams', ['id' => $record->id, 'deleted_at' => null]);
    }

    public function test_can_delete_school_exam_permanently()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(SchoolExam::class)->create();
        $record->delete();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/schools-exams/delete', ['ids' => [$record->id]]);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('schools_exams', ['id' => $record->id]);
    }
}
