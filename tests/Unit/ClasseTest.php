<?php

namespace Tests\Unit;

use App\Models\Classes;
use App\Models\Level;
use App\Models\OptionLevel;
use App\Models\Section;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClasseTest extends TestCase
{
    use WithFaker;

    public function testCanCreateClasse()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $level = Level::create([
            'name' => 'Seconde A',
            'description' => 'Classe préparatoire scientifique',
            'idCycle' => 1,
            'idSchool' => 1,
            'idSection' => 2,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        $user = User::create([
            'name' => 'Test Teacher',
            'username' => $this->faker->unique()->userName,
            'password' => bcrypt('password'),
            'gender' => 'M',
            'email' => $this->faker->unique()->safeEmail,
        ]);

        $optionLevel = OptionLevel::create([
            'name' => 'Test Option',
            'idSchool' => 1,
            'idSection' => 1,
        ]);

        $classes = [
            [
                'name' => $this->faker->name,
                'idTeacher' => $user->id,
                'idOptionLevel' => $optionLevel->id,
                'idLevel' => $level->id,
                'description' => $this->faker->text(20),
                'style' => 'maternelle'
            ],
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/classes', [
                'classes' => $classes
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        $level->delete();
        $user->delete();
        $optionLevel->delete();
    }

    public function testCanUpdateClasse()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $level = Level::create([
            'name' => 'Seconde A',
            'description' => 'Classe préparatoire scientifique',
            'idCycle' => 1,
            'idSchool' => 1,
            'idSection' => 2,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        $user = User::create([
            'name' => 'Test Teacher',
            'username' => $this->faker->unique()->userName,
            'password' => bcrypt('password'),
            'gender' => 'M',
            'email' => $this->faker->unique()->safeEmail,
        ]);

        $optionLevel = OptionLevel::create([
            'name' => 'Test Option 2',
            'idSchool' => 1,
            'idSection' => 1,
        ]);

        $classe = Classes::create([
            'name' => 'Test Class Update',
            'idTeacher' => $user->id,
            'idLevel' => $level->id,
            'idOptionLevel' => $optionLevel->id,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/classes/{$classe->id}", [
                'name' => $this->faker->name,
                'idTeacher' => $user->id,
                'idOptionLevel' => $optionLevel->id,
                'style' => 'maternelle'
//                'idLevel' => 1,
//                'description' => $this->faker->text(20),
//                'users' => [1,2,3,4,5]
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        $level->delete();
        $user->delete();
        $optionLevel->delete();
        $classe->delete();
    }

    public function testCanDeleteAssessmentType()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $section = Section::create([
            'name' => 'Test Section',
            'idSchool' => 1,
            'description' => 'Test description',
        ]);

        $section = Section::create([
            'name' => 'Test Section Update',
            'idSchool' => 1,
            'description' => 'Test description',
        ]);

        $section = Section::create([
            'name' => 'Test Section Delete',
            'idSchool' => 1,
            'description' => 'Test description',
        ]);

        $level = Level::create([
            'name' => 'Seconde A Delete',
            'description' => 'Classe préparatoire scientifique',
            'idCycle' => 1,
            'idSchool' => 1,
            'idSection' => $section->id,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        $user = User::create([
            'name' => 'Test Teacher Delete',
            'username' => $this->faker->unique()->userName,
            'password' => bcrypt('password'),
            'gender' => 'M',
            'email' => $this->faker->unique()->safeEmail,
        ]);

        $optionLevel = OptionLevel::create([
            'name' => 'Test Option Delete',
            'idSchool' => 1,
            'idSection' => 1,
        ]);

        $classes = Classes::create([
            'name' => 'Test Class Delete',
            'idTeacher' => $user->id,
            'idLevel' => $level->id,
            'idOptionLevel' => $optionLevel->id,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->deleteJson("/api/classes/{$classes->id}")
            ->assertStatus(200);

        $classes->update([
            'deleted' => false
        ]);

        $level->delete();
        $user->delete();
        $optionLevel->delete();
        $classes->delete();
    }
}
