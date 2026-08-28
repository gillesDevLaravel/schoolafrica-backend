<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Classes;
use App\Models\Cycle;
use App\Models\Establishment;
use App\Models\Homework;
use App\Models\Level;
use App\Models\Matter;
use App\Models\School;
use App\Models\Section;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeworkTest extends TestCase
{
    use WithFaker;
    use DatabaseTransactions;

    public function testCanGetHomeworks(){
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $school = $this->getOrCreateSchool();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/homeworksall', [
                'idSchool' => $school->id
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanCreateHomework()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $payload = $this->buildHomeworkPayload();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/homeworks', $payload);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanUpdateHomework()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $bo = Homework::latest()->first() ?? $this->createHomeworkForRange($this->faker->date);
        $payload = $this->buildHomeworkPayload();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/homeworks/{$bo->id}", [
                'name' => $payload['name'],
                'deadline' => $payload['deadline'],
                'idClasse' => $payload['idClasse'],
                'idTeacher' => $payload['idTeacher'],
                'idMatter' => $payload['idMatter'],
                'idSchool' => $payload['idSchool'],
                'idSection' => $payload['idSection'] ?? null,
                'idBook' => $payload['idBook'] ?? null,
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanDeleteHomework()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $bo = Homework::latest()->first() ?? $this->createHomeworkForRange($this->faker->date);

        if(!is_null($bo)){
            $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
                ->deleteJson("/api/homeworks/{$bo->id}")
                ->assertStatus(200);
        } else {
            $this->markTestSkipped('Aucun homework disponible pour suppression.');
        }
    }

    public function testCanFilterHomeworksByDateRange()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $inRange = $this->createHomeworkForRange(now()->addDay()->toDateString());
        $outRange = $this->createHomeworkForRange(now()->subYear()->toDateString());

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/homeworksall', [
                'date_start' => now()->toDateString(),
                'date_end' => now()->addDays(2)->toDateString(),
            ]);

        $response->assertStatus(200);

        $ids = array_column($response->json('data') ?? [], 'id');
        $this->assertContains($inRange->id, $ids);
        $this->assertNotContains($outRange->id, $ids);
    }

    private function createHomeworkForRange($deadline)
    {
        $payload = $this->buildHomeworkPayload();
        $payload['deadline'] = $deadline;

        return Homework::create([
            'name' => $payload['name'],
            'deadline' => $payload['deadline'],
            'description' => $this->faker->sentence(),
            'idClasse' => $payload['idClasse'],
            'idMatter' => $payload['idMatter'],
            'idTeacher' => $payload['idTeacher'],
            'idSchool' => $payload['idSchool'],
            'idSection' => $payload['idSection'] ?? null,
            'idBook' => $payload['idBook'] ?? null,
            'created_by' => $payload['idTeacher'],
            'deleted' => false,
        ]);
    }

    private function buildHomeworkPayload()
    {
        $school = $this->getOrCreateSchool();
        $section = $this->getOrCreateSection($school);
        $teacher = $this->getOrCreateTeacher($school, $section);
        $classe = $this->getOrCreateClasse($school, $section, $teacher);
        $matter = $this->getOrCreateMatter($school, $section);
        $book = $this->getOrCreateBook($school, $section, $classe->idLevel ?? null, $teacher);

        $payload = [
            'name' => $this->faker->name,
            'deadline' => $this->faker->date,
            'idClasse' => $classe->id,
            'idTeacher' => $teacher->id,
            'idMatter' => $matter->id,
            'idSchool' => $school->id,
            'idSection' => $section->id,
        ];

        if ($book) {
            $payload['idBook'] = $book->id;
        }

        return $payload;
    }

    private function getOrCreateSchool()
    {
        $school = School::inRandomOrder()->first();
        if ($school) {
            return $school;
        }

        $establishment = Establishment::inRandomOrder()->first() ?? factory(Establishment::class)->create();
        $creator = User::inRandomOrder()->first() ?? factory(User::class)->create();

        return School::create([
            'name' => $this->faker->company,
            'adresse' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'city' => $this->faker->city,
            'section' => 'GENERAL',
            'idEstablishment' => $establishment->id,
            'scholar_level' => 'Secondary',
            'created_by' => $creator->id,
        ]);
    }

    private function getOrCreateSection(School $school)
    {
        $section = Section::where('idSchool', $school->id)->inRandomOrder()->first();
        if ($section) {
            return $section;
        }

        $creator = User::inRandomOrder()->first() ?? factory(User::class)->create();

        return Section::create([
            'name' => 'Section ' . $this->faker->word,
            'description' => $this->faker->sentence(),
            'idSchool' => $school->id,
            'created_by' => $creator->id,
        ]);
    }

    private function getOrCreateCycle(School $school, Section $section)
    {
        $cycle = Cycle::where('idSchool', $school->id)
            ->where('idSection', $section->id)
            ->inRandomOrder()
            ->first();

        if ($cycle) {
            return $cycle;
        }

        $creator = User::inRandomOrder()->first() ?? factory(User::class)->create();

        return Cycle::create([
            'name' => 'Cycle ' . $this->faker->word,
            'idSchool' => $school->id,
            'idSection' => $section->id,
            'description' => $this->faker->sentence(),
            'created_by' => $creator->id,
        ]);
    }

    private function getOrCreateLevel(School $school, Section $section)
    {
        $level = Level::where('idSchool', $school->id)
            ->where('idSection', $section->id)
            ->inRandomOrder()
            ->first();

        if ($level) {
            return $level;
        }

        $cycle = $this->getOrCreateCycle($school, $section);
        $creator = User::inRandomOrder()->first() ?? factory(User::class)->create();

        return Level::create([
            'name' => 'Level ' . $this->faker->word,
            'description' => $this->faker->sentence(),
            'idCycle' => $cycle->id,
            'idSchool' => $school->id,
            'idSection' => $section->id,
            'created_by' => $creator->id,
        ]);
    }

    private function getOrCreateTeacher(School $school, Section $section)
    {
        $teacher = User::where('idSchool', $school->id)->inRandomOrder()->first();

        if ($teacher) {
            return $teacher;
        }

        return factory(User::class)->create([
            'idSchool' => $school->id,
            'idSection' => $section->id,
        ]);
    }

    private function getOrCreateClasse(School $school, Section $section, User $teacher)
    {
        $classe = Classes::where('idSchool', $school->id)
            ->where('idSection', $section->id)
            ->inRandomOrder()
            ->first();

        if ($classe) {
            return $classe;
        }

        $level = $this->getOrCreateLevel($school, $section);

        return Classes::create([
            'name' => 'Classe ' . $this->faker->word,
            'description' => $this->faker->sentence(),
            'idTeacher' => $teacher->id,
            'idLevel' => $level->id,
            'idSchool' => $school->id,
            'idSection' => $section->id,
            'created_by' => $teacher->id,
            'deleted' => false,
        ]);
    }

    private function getOrCreateMatter(School $school, Section $section)
    {
        $matter = Matter::where('idSchool', $school->id)
            ->where('idSection', $section->id)
            ->inRandomOrder()
            ->first();

        if ($matter) {
            return $matter;
        }

        $creator = User::inRandomOrder()->first() ?? factory(User::class)->create();

        return Matter::create([
            'name' => 'Matter ' . $this->faker->word,
            'idSchool' => $school->id,
            'idSection' => $section->id,
            'created_by' => $creator->id,
        ]);
    }

    private function getOrCreateBook(School $school, Section $section, $levelId, User $creator)
    {
        $book = Book::where('idSchool', $school->id)->inRandomOrder()->first();
        if ($book) {
            return $book;
        }

        return Book::create([
            'name' => 'Book ' . $this->faker->words(2, true),
            'status' => 'available',
            'idSchool' => $school->id,
            'idSection' => $section->id,
            'idLevel' => $levelId,
            'created_by' => $creator->id,
            'deleted' => false,
        ]);
    }
}
