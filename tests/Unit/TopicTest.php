<?php

namespace Tests\Unit;

use App\Models\Lesson;
use App\Models\OptionLevel;
use App\Models\School;
use App\Models\Section;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TopicTest extends TestCase
{
    use WithFaker;

    public function testCanGetTopics()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/topicsall', [
                'idSchool' => School::inRandomOrder()->first()->id,
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanCreateTopic()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/topics', [
                'name' => $this->faker->word(),
                'description' => $this->faker->sentence(),
                'startDate' => $this->faker->date(),
                'endDate' => $this->faker->date(),
                'duration' => rand(30,180),
                'status' => 'created',
                'idLesson' => Lesson::inRandomOrder()->first()->id,
                'idSchool' => School::inRandomOrder()->first()->id,
//                'idSection' => Section::inRandomOrder()->first()->id
            ])
            ->assertStatus(201)
            ->assertJsonStructure([
                'data'
            ]);
    }
}
