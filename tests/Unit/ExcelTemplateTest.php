<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExcelTemplateTest extends TestCase
{
    use WithFaker;

    // -------------------------------------------------------------------------
    //  INVOICE TEMPLATE
    // -------------------------------------------------------------------------

    public function testCanDownloadInvoiceTemplate()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/excel-template/download', [
                'type'      => 'invoices',
                'idSchool'  => 2,
                'idSection' => 2,
            ]);

        $response->assertStatus(200);
        $this->assertStringContainsString(
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            $response->headers->get('Content-Type')
        );
        $this->assertNotEmpty($response->getContent());
    }

    // -------------------------------------------------------------------------
    //  RATING TEMPLATE
    // -------------------------------------------------------------------------

    public function testCanDownloadRatingTemplate()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/excel-template/download', [
                'type'      => 'ratings',
                'idSchool'  => 2,
                'idSection' => 2,
            ]);

        $response->assertStatus(200);
        $this->assertStringContainsString(
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            $response->headers->get('Content-Type')
        );
        $this->assertNotEmpty($response->getContent());
    }

    // -------------------------------------------------------------------------
    //  VALIDATION : champs obligatoires manquants
    // -------------------------------------------------------------------------

    public function testDownloadTemplateFailsWithoutType()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/excel-template/download', [
                'idSchool'  => 2,
                'idSection' => 2,
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['type']);
    }

    public function testDownloadTemplateFailsWithInvalidType()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/excel-template/download', [
                'type'      => 'users',
                'idSchool'  => 2,
                'idSection' => 2,
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['type']);
    }

    public function testDownloadTemplateFailsWithoutSchool()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/excel-template/download', [
                'type'      => 'invoices',
                'idSection' => 2,
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['idSchool']);
    }

    public function testDownloadTemplateFailsWithoutSection()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/excel-template/download', [
                'type'     => 'invoices',
                'idSchool' => 2,
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['idSection']);
    }

    public function testDownloadTemplateFailsWithNonExistentSchool()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/excel-template/download', [
                'type'      => 'invoices',
                'idSchool'  => 999999,
                'idSection' => 2,
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['idSchool']);
    }

    public function testDownloadTemplateFailsWithNonExistentSection()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/excel-template/download', [
                'type'      => 'ratings',
                'idSchool'  => 2,
                'idSection' => 999999,
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['idSection']);
    }

    // -------------------------------------------------------------------------
    //  AUTHENTIFICATION
    // -------------------------------------------------------------------------

    public function testDownloadTemplateRequiresAuthentication()
    {
        $this->postJson('/api/excel-template/download', [
            'type'      => 'invoices',
            'idSchool'  => 2,
            'idSection' => 2,
        ])
        ->assertStatus(401);
    }
}
