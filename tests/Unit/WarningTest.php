<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Warning;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WarningTest extends TestCase
{
    use WithFaker;

    public function test_can_get_warnings()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/warningsall')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_show_warning_details()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $warning = factory(Warning::class, 1)->create()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->get("/api/warnings/{$warning->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_store_multiple_warnings_at_once()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $warnings = [
            [
                'idUser' => User::inRandomOrder()->first()->id,
                'reason' => $this->faker->sentence,
                'date' => $this->faker->date('Y-m-d')
            ]
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/warnings', [
                'warnings' => $warnings
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_update_warning()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $warning = factory(Warning::class, 1)->create();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson('/api/warnings/' . $warning[0]->id, [])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        $warning->each(function ($warning) {
            $warning->delete();
        });
    }

    public function test_can_trash_multiple_warnings()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $warnings = factory(Warning::class, 3)->create();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/warnings/trash', [
                'idWarnings' => $warnings->pluck('id')->toArray()
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        $warnings->each(function ($warning) {
            $warning->delete();
        });
    }

    public function test_can_restore_multiple_warnings()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $warnings = factory(Warning::class, 3)->create([
            'deleted' => 1
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/warnings/restore', [
                'idWarnings' => $warnings->pluck('id')->toArray()
            ])
            ->assertStatus(200);

        $warnings->each(function ($warning) {
            $warning->delete();
        });
    }

    public function test_can_delete_multiple_warnings()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $warnings = factory(Warning::class, 3)->create([
            'deleted' => 1
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/warnings/delete', [
                'idWarnings' => $warnings->pluck('id')->toArray()
            ])
            ->assertStatus(200);

        $warnings->each(function ($warning) {
            $warning->delete();
        });
    }
}
