<?php

namespace Tests\Unit;

use App\Models\Rating;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RatingTest extends TestCase
{
    use WithFaker;

    public function testCanStoreMultipleRatings()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $ratings = [
            [
                "value" => $this->faker->randomFloat(2, 0, 5),
                "observation" => null,
                "idCoeficient" => null,
                "idStudent" => 891,
                "idMatter" => 24,
                "idClasse" => 10,
                "idAssessment" => 9,
                "idTeacher" => 7,
                "idSchool" => 2,
                "idSection" => 2,
                "idAssessmentType" => 1,
                "idTypeEvaluation" => 5
            ],
            [
                "value" => $this->faker->randomFloat(2, 0, 10),
                "observation" => null,
                "idCoeficient" => null,
                "idStudent" => 897,
                "idMatter" => 24,
                "idClasse" => 10,
                "idAssessment" => 9,
                "idTeacher" => 7,
                "idSchool" => 2,
                "idSection" => 2,
                "idAssessmentType" => 1,
                "idTypeEvaluation" => 6
            ]
        ];

        $user = User::find(User::find(897)->idParent);
        $user->update([
            'device_key' => $device_key ?? $this->device_key
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/ratings', [
                'ratings' => $ratings,
                'lang' => 'en'
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
                'message',
            ]);

        $response->assertJsonCount(2, 'data');

        parent::unsetDeviceKey($user->id);
    }
    public function testCannotStoreRatingsWithNullValue()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $ratings = [
            [
                "value" => null, // du coup ce array ci ne sera pas enregistré
                "observation" => null,
                "idCoeficient" => null,
                "idStudent" => 891,
                "idMatter" => 24,
                "idClasse" => 10,
                "idAssessment" => 9,
                "idTeacher" => 7,
                "idSchool" => 2,
                "idSection" => 2,
                "idAssessmentType" => 1,
                "idTypeEvaluation" => 5
            ],
            [
                "value" => 1,
                "observation" => null,
                "idCoeficient" => null,
                "idStudent" => 897,
                "idMatter" => 24,
                "idClasse" => 10,
                "idAssessment" => 9,
                "idTeacher" => 7,
                "idSchool" => 2,
                "idSection" => 2,
                "idAssessmentType" => 1,
                "idTypeEvaluation" => 5
            ]
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/ratings', [
                'ratings' => $ratings
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
                'message',
            ]);

        $response->assertJsonCount(1, 'data');
    }

    public function testCanDeleteMultipleRatings()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $ratings_id = Rating::inRandomOrder()->take(rand(1,5))->pluck('id')->toArray();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/ratings/bulk-delete', [
                'ratingsids' => $ratings_id
            ])
            ->assertStatus(204);

        // On remet les valeurs
        Rating::whereIn('id', $ratings_id)->update([
            'deleted' => false,
            'deleted_by' => null
        ]);
    }

    public function testCannotDeleteMultipleRatingsWithEmptyParameters()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/ratings/bulk-delete', [
                'ratingsids' => []
            ])
            ->assertStatus(422);
    }
}
