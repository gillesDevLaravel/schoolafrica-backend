<?php

namespace Tests\Unit;

use App\Models\DailyReport;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DailyReportTest extends TestCase
{
    use WithFaker;

    public function test_can_list_daily_reports_with_filters_and_pagination()
    {
        // Connexion avec un utilisateur autorisé
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        // Préparation des données
        $user = factory(User::class)->create();

        factory(DailyReport::class, 5)->create([
            'user_id' => $user->id,
            'name' => 'Test rapport',
            'description' => 'Test description',
            'comments' => 'Test comments',
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/daily-reportsall');

        // Assertions
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'user',
                        'name',
                        'description',
                        'comments',
                        'date',
                        // Autres champs de la ressource DailyReportResource...
                    ],
                ],
                'links',
                'meta',
            ]);
    }

    public function test_can_create_daily_report()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $user = factory(User::class)->create();

        $data = [
            'user_id'     => $user->id,
            'name'        => 'Test de rapport',
            'description' => 'Test description',
            'comments'    => 'Test comments',
            'date'        => now()->toDateString(),
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/daily-reports', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => __('daily_report.create.success'),
                'data' => [
                    'user' => [
                        'id' => $data['user_id']
                    ],
                    'name'    => $data['name'],
                    'description' => $data['description'],
                    'comments' => $data['comments'],
                ]
            ]);

        $this->assertDatabaseHas('daily_reports', [
            'user_id' => $data['user_id'],
            'name'    => $data['name'],
        ]);
    }

    public function test_can_show_daily_report()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $dailyReport = factory(DailyReport::class)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->getJson("/api/daily-reports/{$dailyReport->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $dailyReport->id,
                    'user' => [
                        'id' => $dailyReport->user_id
                    ],
                    'name' => $dailyReport->name,
                    'description' => $dailyReport->description,
                    'comments' => $dailyReport->comments,
                ]
            ]);
    }

    public function test_can_update_daily_report()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $dailyReport = factory(DailyReport::class)->create([
            'name' => 'Rapport initial',
        ]);

        $updateData = [
            'name' => 'Rapport mis à jour',
            'comments' => 'Comments mis à jour',
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->putJson("/api/daily-reports/{$dailyReport->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => __('daily_report.update.success'),
                'data' => [
                    'name' => 'Rapport mis à jour',
                    'comments' => 'Comments mis à jour',
                ]
            ]);

        $this->assertDatabaseHas('daily_reports', [
            'id' => $dailyReport->id,
            'name' => 'Rapport mis à jour',
        ]);
    }

    public function test_can_archive_daily_report()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $report = factory(DailyReport::class)->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/daily-reports/trash', ['ids' => [$report->id]]);

        $response->assertStatus(204);
        $this->assertSoftDeleted('daily_reports', ['id' => $report->id]);
    }

    public function test_can_restore_daily_report()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $report = factory(DailyReport::class)->create();
        $report->delete();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/daily-reports/restore', ['ids' => [$report->id]]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'success' => true,
                'message' => __('daily_report.restore.success'),
            ]);

        $this->assertDatabaseHas('daily_reports', ['id' => $report->id, 'deleted_at' => null]);
    }

    public function test_can_delete_daily_report_permanently()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);
        $token = json_decode($login->getContent())->data->token;

        $report = factory(DailyReport::class)->create();
        $report->delete();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/daily-reports/delete', ['ids' => [$report->id]]);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('daily_reports', ['id' => $report->id]);
    }
}
