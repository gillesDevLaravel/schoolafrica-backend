<?php

namespace Tests\Unit;

use App\Models\SchoolDelay;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SchoolDelayTest extends TestCase
{
    use WithFaker;

    public function test_can_list_school_delays_with_filters_and_pagination()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $student = factory(User::class)->create();


        factory(SchoolDelay::class, 5)->create([
            'idStudent' => $student->id,

            'hour' => '08:00',
            'type' => 'late',
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/school-delaysall');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'student',
                        'course',
                        'hour',
                        'date',
                        'description',
                        'type',
                        'created_by',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'links',
                'meta',
            ]);
    }

    public function test_can_create_school_delay()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $student = factory(User::class)->create();
//
        $data = [
            'idStudents'   => [$student->id],
  //          'idCourse'    => $course->id,
            'hour'        => '09:00',
            'date'        => $this->faker->date(),
            'description' => $this->faker->optional()->sentence,
            'type'        => 'late',
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/school-delays', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => __('schoolDelay.create.success'),
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => [ // La collection de retards
                        'id',
                        'student',
                        'course',
                        'hour',
                        'date',
                        'description',
                        'type',
                        'created_by',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);

        $this->assertDatabaseHas('school_delays', [
            'idStudent' => $student->id,
            'hour' => $data['hour'],
            'type' => $data['type'],
        ]);
    }

    public function test_can_show_school_delay()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

       $record = factory(SchoolDelay::class)->create([
           'type' => 'late',
       ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->getJson("/api/school-delays/{$record->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $record->id,
                  'student' => ['id' => $record->idStudent],
                  'type' => $record->type,
     //             'course' => ['id' => $record->idCourse],
      //          'hour' => $record->hour,
      //            'date' => $record->date,

                ]
            ]);
    }

    public function test_can_update_school_delay()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(SchoolDelay::class)->create([
            'hour' => '08:00',
        ]);

        $updateData = [
            'hour'        => '10:00',
            'date'        => $this->faker->date(),
            'description' => $this->faker->optional()->sentence,
            'type'        => 'justified',
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->putJson("/api/school-delays/{$record->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => __('schoolDelay.update.success'),
                'data' => [
                    'hour' => $updateData['hour'],
                    'date' => $updateData['date'],
                    'description' => $updateData['description'],
                    'type' => $updateData['type'],
                ]
            ]);

        $this->assertDatabaseHas('school_delays', [
            'id' => $record->id,
            'hour' => '10:00',
            'type' => $updateData['type'],
        ]);
    }

    public function test_can_archive_school_delay()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(SchoolDelay::class)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/school-delays/trash', ['ids' => [$record->id]]);

        $response->assertStatus(204);
        $this->assertSoftDeleted('school_delays', ['id' => $record->id]);
    }

    public function test_can_restore_school_delay()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(SchoolDelay::class)->create();
        $record->delete();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/school-delays/restore', ['ids' => [$record->id]]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'success' => true,
                'message' => __('schoolDelay.restore.success'),
            ]);

        $this->assertDatabaseHas('school_delays', ['id' => $record->id, 'deleted_at' => null]);
    }

    public function test_can_delete_school_delay_permanently()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(SchoolDelay::class)->create();
        $record->delete();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/school-delays/delete', ['ids' => [$record->id]]);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('school_delays', ['id' => $record->id]);
    }
}
