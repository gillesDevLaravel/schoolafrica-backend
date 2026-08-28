<?php

namespace Tests\Unit;

use App\Models\AcademicYear;
use App\Models\ScanReceipt;
use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ScanReceiptTest extends TestCase
{
    use WithFaker;

    public function test_can_get_scan_receipts()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/scan-receiptsall');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_create_scan_receipt()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);


        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/scan-receipts', [
                'idAcademicYear' => factory(AcademicYear::class)->create()->id,
                'idSchool' => School::first()->id,
                'idStudent' => User::inRandomOrder()->first()->id,
                'image_scan' => $this->faker->name,
            ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_update_scan_receipt()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $scanReceipt = factory(ScanReceipt::class)->create();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/scan-receipts/{$scanReceipt->id}", [
                'idAcademicYear' => factory(AcademicYear::class)->create()->id,
                'idSchool' => School::first()->id,
                'idStudent' => User::inRandomOrder()->first()->id,
                'image_scan' => $this->faker->name,
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        $scanReceipt->delete();
    }
}
