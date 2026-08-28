<?php

namespace Tests\Unit;

use App\Models\Project;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use WithFaker;

    public function testCanGetProjects() {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/projectsall')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'links',
                'meta',
            ]);
    }

    public function testCanCreateProject()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $params = [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->date,
            'users' => [1,2]
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/projects', $params)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data',
            ]);
    }

    public function testCanCreateMultipleProjects()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $params = [
            [
                'name' => $this->faker->word,
                'description' => $this->faker->sentence,
                'start_date' => $this->faker->date,
                'end_date' => $this->faker->date,
                'users' => [1,2]
            ],[
                'name' => $this->faker->word,
                'description' => $this->faker->sentence,
                'start_date' => $this->faker->date,
                'end_date' => $this->faker->date,
                'users' => [1,2,5]
            ]
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/projects-bulk', [
                'projects' => $params
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
            ]);
    }

    public function testCanGetSingleProjectDetails() {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $project = Project::orderBy('id', 'desc')->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->getJson("/api/projects/{$project->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
            ]);
    }

    public function testCanUpdateProject()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $params = [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->date,
            'users' => [1,3]
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson('/api/projects/1', $params)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
            ]);
    }

    public function testCanTrashProject()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $project = Project::first();
        $project->update([
            'deleted' => false // Pour s'assurer que le projet ne soit pas supprimé avant que le test ne soit exécuté
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->delete("/api/projects/trash/{$project->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
            ]);

        $project->update([
            'deleted' => false
        ]);
    }

    public function testCannotTrashADeletedProject()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $project = Project::first();
        $project->update([
            'deleted' => true // Pour s'assurer que le projet ne soit pas supprimé avant que le test ne soit exécuté
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->delete("/api/projects/trash/{$project->id}")
            ->assertStatus(404);
    }

    public function testCanRestoreProject()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $project = Project::withoutGlobalScope('isDeleted')->first();

        $project->update([
            'deleted' => true // Pour s'assurer que le projet soit supprimé avant que le test ne soit exécuté
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/projects/restore/{$project->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
            ]);
    }

    public function testCannotRestoreUnTrashedProject()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $project = Project::withoutGlobalScope('isDeleted')->first();
        $project->update([
            'deleted' => false // On force la NON suppression du projet pour s'assurer que le test échoue et retourne 404
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/projects/restore/{$project->id}")
            ->assertStatus(404);
    }
}
