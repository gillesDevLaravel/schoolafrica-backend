<?php

namespace Tests\Unit;

use App\Models\Homework;
use App\Models\HomeworkDone;
use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeworkDoneTest extends TestCase
{
    use WithFaker;
    use DatabaseTransactions;

    public function testCanGetHomeworkDones(){
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $record = $this->createHomeworkDoneRecord();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/homeworkdonesall', [
                'idSchool' => $record->idSchool
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanCreateHomeworkDone()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $payload = $this->buildHomeworkDonePayload();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/homeworkdones', $payload);

//        dd($response->getContent());

            $response->assertStatus(201)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanUpdateHomeworkDone()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $homework_done = $this->createHomeworkDoneRecord();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/homeworkdones/{$homework_done->id}", [
                'description' => $this->faker->sentence(),
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanDeleteHomeworkDone()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $homework_done = $this->createHomeworkDoneRecord();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->deleteJson("/api/homeworkdones/{$homework_done->id}")
            ->assertStatus(200);
    }

    public function testCanDownloadHomeworkDone()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $homework = Homework::inRandomOrder()->first();

        if (!$homework) {
            $this->markTestSkipped('Aucun homework disponible pour le téléchargement.');
        }

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/homeworkdones/download", [
                'idHomework' => $homework->id

            ]);

        // Si y'a pas d'enregistrement sur la table avec idHomework, on s'assure qu'on a bien un 404
        if(count(HomeworkDone::where('idHomework', $homework)->get()) === 0){
            $response->assertStatus(404);
        }else{
            $response->assertStatus(200);

            $this->assertMatchesRegularExpression(
                '/^https?:\/\/.+\.(zip|pdf)$/',
                $response->json('data')
            );
        }
    }

    public function testCanFilterHomeworkDonesByDateRange()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $inRange = $this->createHomeworkDoneForRange(now()->subDay()->toDateString());
        $outRange = $this->createHomeworkDoneForRange(now()->subYear()->toDateString());

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/homeworkdonesall', [
                'date_start' => now()->subDays(2)->toDateString(),
                'date_end' => now()->toDateString(),
            ]);

        $response->assertStatus(200);

        $ids = array_column($response->json('data') ?? [], 'id');
        $this->assertContains($inRange->id, $ids);
        $this->assertNotContains($outRange->id, $ids);
    }

    private function createHomeworkDoneForRange($createdAt)
    {
        $homework = $this->getHomeworkOrSkip();
        $student = $this->getStudentForHomework($homework);
        $school = School::find($homework->idSchool);

        $record = new HomeworkDone([
            'description' => $this->faker->sentence(),
            'idStudent' => $student->id,
            'idHomework' => $homework->id,
            'idSchool' => $school->id,
            'idSection' => $homework->idSection ?? $student->idSection ?? null,
            'created_by' => $student->id,
        ]);

        $record->created_at = $createdAt;
        $record->updated_at = $createdAt;
        $record->timestamps = false;
        $record->save();

        return $record;
    }

    private function buildHomeworkDonePayload()
    {
        $homework = $this->getHomeworkOrSkip();
        $student = $this->getStudentForHomework($homework);

        return [
            'description' => $this->faker->sentence(),
            'idStudent' => $student->id,
            'idHomework' => $homework->id,
        ];
    }

    private function createHomeworkDoneRecord()
    {
        $homework = $this->getHomeworkOrSkip();
        $student = $this->getStudentForHomework($homework);

        return HomeworkDone::create([
            'description' => $this->faker->sentence(),
            'idStudent' => $student->id,
            'idHomework' => $homework->id,
            'idSchool' => $student->idSchool,
            'idSection' => $student->idSection ?? null,
            'created_by' => $student->id,
        ]);
    }

    private function getHomeworkOrSkip()
    {
        $homework = Homework::inRandomOrder()->first();

        if (!$homework) {
            $this->markTestSkipped('Aucun homework disponible pour créer un homework done.');
        }

        return $homework;
    }

    private function getStudentForHomework(Homework $homework)
    {
        $student = User::where('idSchool', $homework->idSchool)->inRandomOrder()->first();

        if (!$student) {
            $student = factory(User::class)->create([
                'idSchool' => $homework->idSchool,
                'idSection' => $homework->idSection ?? null,
            ]);
        }

        return $student;
    }
}
