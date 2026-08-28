<?php

namespace Tests\Unit;

use App\Enums\NoteFraiStatusEnum;
use App\Models\NoteFrais;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NoteFraisTest extends TestCase
{
    use WithFaker;

    public function testCanGetNoteFrais()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/note-fraisall", [
                'idSchool' => 1
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanStoreNoteFrais()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $note_frais = [
            [
                'idUser' => 1,
                'idUserApprove' => 1,
                'libelle' => $this->faker->word,
                'description' => $this->faker->word,
                'amount' => $this->faker->randomNumber(4),
                "date" => "11-07-2025",
            ]
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/note-frais", [
                'note_frais' => $note_frais
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanUpdateNoteFrais()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $note_frais = NoteFrais::latest()->first();
        $note_frais->idUserApprove = json_decode($login->getContent())->data->id; // on modifie le idUserApprove pour ce l'auth puisse modifier la note de frais
        $note_frais->save();
        $note_frais->refresh();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/note-frais/{$note_frais->id}", [
                'libelle' => $this->faker->word,
                'amount' => $this->faker->randomNumber(4),
                "description" => $this->faker->word,
                "date" => "11-07-2025",
//                "status" => $this->faker->word,
//                "date" => $this->faker->date
            ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanTrashNoteFrais()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $note_frais = NoteFrais::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->delete("/api/note-frais/trash/{$note_frais->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        $note_frais->update([
            'deleted' => false,
            'deleted_by' => null,
        ]);
    }

    public function testCanRestoreNoteFrais()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $note_frais = NoteFrais::withoutGlobalScope('isDeleted')->latest()->first();

        $note_frais->update([
            'deleted' => true,
            'deleted_by' => auth()->user()->id,
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/note-frais/restore/{$note_frais->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }
}
