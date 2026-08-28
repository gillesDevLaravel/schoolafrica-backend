<?php

namespace Tests\Unit;

use App\Models\School;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use WithFaker;

    public function testCanRegisterStudentWithGoodParams()
    {
        try {
            $school = School::find(2);

            $genders = ['Male', 'Female'];

            $params = [
                "username" => $this->faker->userName,
                "password" => '000000',
                "matricule" => $this->faker->regexify('[A-Z0-9]{12}'),
                "role" => 8,
                "phone" => $this->faker->phoneNumber,
                "gender" => $genders[rand(0,1)],
                "name" => $this->faker->name,
                "email" => $this->faker->email,
                "observation" => $this->faker->text(120),
                'idSection' => $school->sections()->pluck('id')->toArray()[0],
                "idClasse" => $school->classes()->pluck('id')->toArray()[0],
            ];

            $resp = $this->postJson('/api/register', $params);

            parent::assertResponseStatus($resp, 200);

            $resp->assertJsonStructure([
                'success',
                'data',
                'message'
            ]);
        } catch (\Exception $e){
            $this->fail($e->getMessage());
        }
    }

    public function testCannotRegisterStudentWithMissingParam()
    {
        try {
            $school = School::find(2);

            $genders = ['Male', 'Female'];

            $params = [
                "username" => $this->faker->userName,
                "password" => '000000',
                "matricule" => $this->faker->regexify('[A-Z0-9]{12}'),
                "role" => 8,
                "phone" => $this->faker->phoneNumber,
                "gender" => $genders[rand(0,1)],
                "name" => $this->faker->name,
                "email" => $this->faker->email,
                'idSection' => $school->sections()->pluck('id')->toArray()[0],
//                "idClasse" => $school->classes()->pluck('id')->toArray()[0],
            ];

            $resp = $this->postJson('/api/register', $params);

            parent::assertResponseStatus($resp, 404);

            $resp->assertJsonStructure([
                'success',
                'message'
            ]);
        } catch (\Exception $e){
            $this->fail($e->getMessage());
        }
    }

    public function testCannotRegisterStudentWithMissingRequiredParams()
    {
        try {
            $school = School::find(2);

            $genders = ['Male', 'Female'];

            $params = [
                "username" => $this->faker->userName,
                "password" => '000000',
                "matricule" => $this->faker->regexify('[A-Z0-9]{12}'),
//                "role" => 8,
                "phone" => $this->faker->phoneNumber,
                "gender" => $genders[rand(0,1)],
                "name" => $this->faker->name,
                "email" => $this->faker->email,
                'idSection' => $school->sections()->pluck('id')->toArray()[0],
//                "idClasse" => $school->classes()->pluck('id')->toArray()[0],
            ];

            $resp = $this->postJson('/api/register', $params);

            parent::assertResponseStatus($resp, 422);

            $resp->assertJsonStructure([
                'success',
                'message'
            ]);
        } catch (\Exception $e){
            $this->fail($e->getMessage());
        }
    }

    public function testCanRegisterStaffMemberWithGoodParams()
    {
        try {
            $school = School::find(2);

            $genders = ['Male', 'Female'];

            $params = [
                "username" => $this->faker->userName,
                "password" => '000000',
                "matricule" => $this->faker->regexify('[A-Z0-9]{12}'),
                "role" => 8,
                "phone" => $this->faker->phoneNumber,
                "gender" => $genders[rand(0,1)],
                "name" => $this->faker->name,
                "email" => $this->faker->email,
                "observation" => $this->faker->text(120),
                'idSection' => $school->sections()->pluck('id')->toArray()[0],
                "idClasse" => $school->classes()->pluck('id')->toArray()[0],
                "profession" => "Testeur",
                "bank_name" => "UBA",
                "bank_rib" => "01020304050607",
            ];

            $resp = $this->postJson('/api/register', $params);

            parent::assertResponseStatus($resp, 200);

            $resp->assertJsonStructure([
                'success',
                'data',
                'message'
            ]);
        } catch (\Exception $e){
            $this->fail($e->getMessage());
        }
    }
}
