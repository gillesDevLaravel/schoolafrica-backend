<?php

namespace Tests\Unit;

use App\Models\School;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SchoolTest extends TestCase
{
    use WithFaker;

    public function test_can_get_schools()
    {
        $login = parent::login([
            'username' => 'dev',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->getJson('/api/schools');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_create_school_with_legal_documents()
    {
        $login = parent::login([
            'username' => 'dev',
            'password' => '000000'
        ]);

        $schoolData = [
            'name' => $this->faker->company . ' ' . time(),
            'adresse' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'city' => $this->faker->city,
            'section' => 'A',
            'scholar_level' => 'Primaire',
            'idEstablishment' => 1,
            'matricule_code' => 'MAT' . time(),
            'email' => $this->faker->companyEmail,
            'website' => $this->faker->url,
            // Champs images (chemins de fichiers)
            'land_title' => 'uploads/schools/land_title_' . time() . '.jpg',
            'building_permit' => 'uploads/schools/building_permit_' . time() . '.jpg',
            'creation_authorization' => 'uploads/schools/creation_auth_' . time() . '.jpg',
            'opening_authorization' => 'uploads/schools/opening_auth_' . time() . '.jpg',
            // Champs documents
            'nui' => 'NUI-' . $this->faker->numerify('######'),
            'cnps' => 'CNPS-' . $this->faker->numerify('#########'),
            'location_plan' => 'uploads/schools/location_plan_' . time() . '.pdf',
            'information_sheets' => 'Fiches de renseignements - ' . $this->faker->sentence,
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/schools', $schoolData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'land_title',
                    'building_permit',
                    'creation_authorization',
                    'opening_authorization',
                    'nui',
                    'cnps',
                    'location_plan',
                    'information_sheets'
                ]
            ]);

        // Clean up
        $createdId = $response->getData()->data->id;
        if ($createdId) {
            School::find($createdId)->delete();
        }
    }

    public function test_can_show_school_details()
    {
        $login = parent::login([
            'username' => 'dev',
            'password' => '000000'
        ]);

        $school = School::first();

        if (!$school) {
            $this->markTestSkipped('No school found in database');
        }

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->getJson("/api/schools/{$school->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'land_title',
                    'building_permit',
                    'creation_authorization',
                    'opening_authorization',
                    'nui',
                    'cnps',
                    'location_plan',
                    'information_sheets'
                ]
            ]);
    }

    public function test_can_update_school_legal_documents()
    {
        $login = parent::login([
            'username' => 'dev',
            'password' => '000000'
        ]);

        $school = School::first();

        if (!$school) {
            $this->markTestSkipped('No school found in database');
        }

        $updateData = [
            'name' => $school->name,
            'adresse' => $school->adresse,
            'phone' => $school->phone,
            'city' => $school->city,
            'section' => $school->section,
            'scholar_level' => $school->scholar_level,
            'idEstablishment' => $school->idEstablishment,
            'matricule_code' => $school->matricule_code,
            // Mise à jour des documents légaux
            'land_title' => 'uploads/schools/updated_land_title_' . time() . '.jpg',
            'building_permit' => 'uploads/schools/updated_building_permit_' . time() . '.jpg',
            'creation_authorization' => 'uploads/schools/updated_creation_auth_' . time() . '.jpg',
            'opening_authorization' => 'uploads/schools/updated_opening_auth_' . time() . '.jpg',
            'nui' => 'NUI-UPDATED-' . $this->faker->numerify('######'),
            'cnps' => 'CNPS-UPDATED-' . $this->faker->numerify('#########'),
            'location_plan' => 'uploads/schools/updated_location_plan_' . time() . '.pdf',
            'information_sheets' => 'Fiches mises à jour - ' . $this->faker->sentence,
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/schools/{$school->id}", $updateData)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'land_title',
                    'building_permit',
                    'creation_authorization',
                    'opening_authorization',
                    'nui',
                    'cnps',
                    'location_plan',
                    'information_sheets'
                ]
            ]);
    }

    public function test_can_delete_school()
    {
        $login = parent::login([
            'username' => 'dev',
            'password' => '000000'
        ]);

        // Créer une école temporaire pour le test de suppression
        $school = School::create([
            'name' => 'Test School to Delete ' . time(),
            'adresse' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'city' => $this->faker->city,
            'section' => 'A',
            'scholar_level' => 'Primaire',
            'idEstablishment' => 1,
            'matricule_code' => 'MAT-DEL-' . time(),
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->deleteJson("/api/schools/{$school->id}")
            ->assertStatus(200);
    }
}
