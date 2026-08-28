<?php

namespace Tests\Unit;

use App\Models\Lesson;
use App\Models\LessonSummary;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LessonSummaryTest extends TestCase
{
    use WithFaker;

    public function test_can_get_lesson_summaries()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/lessons-summariesall')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_create_multiple_lessons_summaries()
    {
        $login = parent::login([
            'username' => 'teacheru',
            'password' => '000000'
        ]);

        $lesson_summaries = [
            [
                'idLesson' => Lesson::all()->random()->id,
                'idTeacher' => json_decode($login->getContent())->data->id,
                'description' => $this->faker()->text,
                'date' => $this->faker->date,
            ],
            [
                'idLesson' => Lesson::all()->random()->id,
                'idTeacher' => json_decode($login->getContent())->data->id,
                'description' => $this->faker()->text,
                'date' => $this->faker->date,
            ],
            [
                'idLesson' => Lesson::all()->random()->id,
                'idTeacher' => json_decode($login->getContent())->data->id,
                'description' => $this->faker()->text,
                'date' => $this->faker->date,
            ],
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/lessons-summaries', [
                'lesson_summaries' => $lesson_summaries
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_cannot_create_multiple_lessons_summaries_if_not_teacher()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $lesson_summaries = [
            [
                'idLesson' => Lesson::all()->random()->id,
                'idTeacher' => json_decode($login->getContent())->data->id,
                'description' => $this->faker()->text,
                'date' => $this->faker->date,
            ],
            [
                'idLesson' => Lesson::all()->random()->id,
                'idTeacher' => json_decode($login->getContent())->data->id,
                'description' => $this->faker()->text,
                'date' => $this->faker->date,
            ],
            [
                'idLesson' => Lesson::all()->random()->id,
                'idTeacher' => json_decode($login->getContent())->data->id,
                'description' => $this->faker()->text,
                'date' => $this->faker->date,
            ],
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/lessons-summaries', [
                'lesson_summaries' => $lesson_summaries
            ])
            ->assertStatus(403);
    }

    public function test_can_update_lesson_summary()
    {
        $login = parent::login([
            'username' => 'teacheru',
            'password' => '000000'
        ]);

        $lesson_summary = factory(LessonSummary::class)->create([
            'idTeacher' => json_decode($login->getContent())->data->id,
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson('/api/lessons-summaries/' . $lesson_summary->id, [])
            ->assertStatus(200);
    }

    public function test_cannot_update_another_teacher_lesson_summary()
    {
        $login = parent::login([
            'username' => 'teacheru',
            'password' => '000000'
        ]);

        $lesson_summary = factory(LessonSummary::class)->create([
            'idTeacher' => 1, // et qui n'est clairement pas l'utilisateur connecté
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson('/api/lessons-summaries/' . $lesson_summary->id, [])
            ->assertStatus(403);
    }

    public function test_can_trash_lesson_summaries()
    {
        $login = parent::login([
            'username' => 'teacheru',
            'password' => '000000'
        ]);

        $lesson_summaries = factory(LessonSummary::class, 5)->create([
            'idTeacher' => json_decode($login->getContent())->data->id,
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/lessons-summaries/trash", [
                'ids' => $lesson_summaries->pluck('id')->toArray()
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        collect($lesson_summaries)->each(function ($holiday) {
            $holiday->delete();
        });
    }

    public function test_can_restore_lesson_summaries()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $lesson_summaries = factory(LessonSummary::class, 5)->create([
            'idTeacher' => json_decode($login->getContent())->data->id,
            'deleted' => 1
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/lessons-summaries/restore", [
                'ids' => $lesson_summaries->pluck('id')->toArray()
            ])
            ->assertStatus(200);

        collect($lesson_summaries)->each(function ($holiday) {
            $holiday->delete();
        });
    }

    public function test_cannot_restore_lesson_summaries_if_not_allowed()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $lesson_summaries = factory(LessonSummary::class, 5)->create([
            'idTeacher' => json_decode($login->getContent())->data->id,
            'deleted' => 1
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/lessons-summaries/restore", [
                'ids' => $lesson_summaries->pluck('id')->toArray()
            ])
            ->assertStatus(403);

        collect($lesson_summaries)->each(function ($holiday) {
            $holiday->delete();
        });
    }

    public function test_can_delete_lesson_summaries()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $lesson_summaries = factory(LessonSummary::class, 3)->create([
            'idTeacher' => json_decode($login->getContent())->data->id,
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/lessons-summaries/delete", [
                'ids' => $lesson_summaries->pluck('id')->toArray()
            ])
            ->assertStatus(200);
    }

    public function test_cannot_delete_lesson_summaries_if_not_admin()
    {
        $login = parent::login([
            'username' => 'teacheru',
            'password' => '000000'
        ]);

        $lesson_summaries = factory(LessonSummary::class, 3)->create([
            'idTeacher' => json_decode($login->getContent())->data->id,
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/lessons-summaries/delete", [
                'ids' => $lesson_summaries->pluck('id')->toArray()
            ])
            ->assertStatus(403);
    }
}
