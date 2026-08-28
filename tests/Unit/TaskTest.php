<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use WithFaker;

    public function testCanCreateTasks()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $tasks = [
            [
                'name' => $this->faker->name,
                'due_date' => $this->faker->date,
                'priority' => 'high',
                'status' => "Create",
                'idUser' => 1,
//                'estimation' => rand(45,300),
                'duree_mise' => rand(45,300),
                'start_date' => $this->faker->date,
                'observation' => $this->faker->sentence(),
                'idProject' => rand(0, Project::count()),
                'idSchool' => 1,
//                'idSection' => 1,
            ],
            [
                'name' => $this->faker->name,
                'due_date' => $this->faker->date,
                'priority' => 'high',
                'status' => "Create",
                'idUser' => 1,
//                'estimation' => rand(45,300),
                'duree_mise' => rand(45,300),
                'start_date' => $this->faker->date,
                'observation' => $this->faker->sentence(),
                'idProject' => rand(0, Project::count()),
                'idSchool' => 1,
                'idSection' => 2,
            ],
            [
                'name' => $this->faker->name,
                'due_date' => $this->faker->date,
                'priority' => 'low',
                'status' => "Finish",
                'description' => $this->faker->text(300),
                'estimation' => rand(45,300),
                'duree_mise' => rand(45,300),
                'start_date' => $this->faker->date,
                'observation' => $this->faker->sentence(),
                'idProject' => rand(0, Project::count()),
                'idUser' => 2,
                'idSchool' => 2,
                'idSection' => 2,
            ]
        ];

        User::find(2)->update([
            'device_key' => $device_key ?? $this->device_key
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/tasks', [
                'tasks' => $tasks
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        parent::unsetDeviceKey(2);
    }

    public function testCanUpdateTask()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $task = Task::orderBy('id', 'desc')->first();

        $params = [
            'name' => $this->faker->name,
            'due_date' => $this->faker->date,
            'priority' => 'high',
            'status' => "Create",
            'idUser' => 1,
            'estimation' => rand(45,300),
            'duree_mise' => rand(45,300),
            'start_date' => $this->faker->date,
            'observation' => $this->faker->sentence(),
            'idProject' => rand(0, Project::count()),
            'idSchool' => 1,
            'idSection' => 1,
        ];

        User::find(2)->update([
            'device_key' => $device_key ?? $this->device_key
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/tasks/{$task->id}", $params)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        parent::unsetDeviceKey(2);
    }
}
