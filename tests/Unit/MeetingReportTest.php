<?php

namespace Tests\Unit;

use App\Models\MeetingReport;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MeetingReportTest extends TestCase
{
    use WithFaker;

    public function test_can_list_meeting_reports_with_filters_and_pagination()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        factory(MeetingReport::class, 5)->create([
            'type' => 'Conseil d\'Administration',
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/meeting-reportsall');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'type',
                        'description',
                        'date',
                        'participants',
                        'created_by',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'links',
                'meta',
            ]);
    }

    public function test_can_list_meeting_reports_with_name_filter()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        factory(MeetingReport::class)->create([
            'name' => 'Réunion Conseil d\'Administration',
            'type' => 'Conseil d\'Administration',
            
        ]);

        factory(MeetingReport::class)->create([
            'name' => 'Réunion Technique',
            'type' => 'Réunion Technique',
            
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/meeting-reportsall?name=Conseil');

        $response->assertStatus(200);
        $this->assertEquals(1, count($response->json('data')));
    }

    public function test_can_list_meeting_reports_with_type_filter()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        factory(MeetingReport::class)->create([
            'name' => 'Réunion Conseil 1',
            'type' => 'Conseil d\'Administration',
            
        ]);

        factory(MeetingReport::class)->create([
            'name' => 'Réunion Conseil 2',
            'type' => 'Conseil d\'Administration',
            
        ]);

        factory(MeetingReport::class)->create([
            'name' => 'Réunion Technique',
            'type' => 'Réunion Technique',
            
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/meeting-reportsall?type=Conseil d\'Administration');

        $response->assertStatus(200);
        $this->assertEquals(2, count($response->json('data')));
    }

    public function test_can_list_meeting_reports_with_filter_value()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        factory(MeetingReport::class)->create([
            'name' => 'Réunion Conseil d\'Administration',
            'type' => 'Conseil d\'Administration',
            'description' => 'Discussion sur le budget annuel',
            
        ]);

        factory(MeetingReport::class)->create([
            'name' => 'Réunion Technique',
            'type' => 'Réunion Technique',
            'description' => 'Mise à jour du système',
            
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/meeting-reportsall?filter_value=budget');

        $response->assertStatus(200);
        $this->assertEquals(1, count($response->json('data')));
    }

    public function test_can_create_multiple_meeting_reports()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $data = [
            'meeting_reports' => [
                [
                    'name'        => $this->faker->sentence(3),
                    'type'        => 'Conseil d\'Administration',
                    'description' => $this->faker->optional()->sentence,
                    
                ],
                [
                    'name'        => $this->faker->sentence(3),
                    'type'        => 'Réunion Technique',
                    'description' => $this->faker->optional()->sentence,
                    
                ],
            ]
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/meeting-reports', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => __('meeting_report.create.success'),
            ]);

        foreach ($data['meeting_reports'] as $meeting_report) {
            $this->assertDatabaseHas('meeting_reports', [
                'name'   => $meeting_report['name'],
                'type'   => $meeting_report['type'],
                
            ]);
        }
    }

    public function test_can_show_meeting_report()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(MeetingReport::class)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->getJson("/api/meeting-reports/{$record->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $record->id,
                    'name' => $record->name,
                    'type' => $record->type,
                    'description' => $record->description,
                    'created_by' => [
                        'id' => $record->created_by,
                    ],
                ]
            ]);
    }

    public function test_can_update_meeting_report()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(MeetingReport::class)->create([
            
        ]);

        $updateData = [
            
            'description' => $this->faker->optional()->sentence,
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->putJson("/api/meeting-reports/{$record->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => __('meeting_report.update.success'),
                'data' => [
                    
                    'description' => $updateData['description'],
                ]
            ]);

        $this->assertDatabaseHas('meeting_reports', [
            'id' => $record->id,
            
        ]);
    }

    public function test_can_archive_meeting_report()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(MeetingReport::class)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/meeting-reports/trash', ['ids' => [$record->id]]);

        $response->assertStatus(204);
        $this->assertSoftDeleted('meeting_reports', ['id' => $record->id]);
    }

    public function test_can_restore_meeting_report()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(MeetingReport::class)->create();
        $record->delete();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/meeting-reports/restore', ['ids' => [$record->id]]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'success' => true,
                'message' => __('meeting_report.restore.success'),
            ]);

        $this->assertDatabaseHas('meeting_reports', ['id' => $record->id, 'deleted_at' => null]);
    }

    public function test_can_delete_meeting_report_permanently()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $record = factory(MeetingReport::class)->create();
        $record->delete();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/meeting-reports/delete', ['ids' => [$record->id]]);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('meeting_reports', ['id' => $record->id]);
    }

    public function test_can_archive_multiple_meeting_reports()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $records = factory(MeetingReport::class, 3)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/meeting-reports/trash', ['ids' => $records->pluck('id')->toArray()]);

        $response->assertStatus(204);
        
        foreach ($records as $record) {
            $this->assertSoftDeleted('meeting_reports', ['id' => $record->id]);
        }
    }

    public function test_can_restore_multiple_meeting_reports()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $records = factory(MeetingReport::class, 3)->create();
        foreach ($records as $record) {
            $record->delete();
        }

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/meeting-reports/restore', ['ids' => $records->pluck('id')->toArray()]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'success' => true,
                'message' => __('meeting_report.restore.success'),
            ]);
        
        foreach ($records as $record) {
            $this->assertDatabaseHas('meeting_reports', ['id' => $record->id, 'deleted_at' => null]);
        }
    }

    public function test_can_delete_multiple_meeting_reports_permanently()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $records = factory(MeetingReport::class, 3)->create();
        foreach ($records as $record) {
            $record->delete();
        }

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/meeting-reports/delete', ['ids' => $records->pluck('id')->toArray()]);

        $response->assertStatus(204);
        
        foreach ($records as $record) {
            $this->assertDatabaseMissing('meeting_reports', ['id' => $record->id]);
        }
    }
}
