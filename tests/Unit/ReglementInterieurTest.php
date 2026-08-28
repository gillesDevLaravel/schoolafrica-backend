<?php

namespace Tests\Unit;

use App\Models\ReglementInterieur;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReglementInterieurTest extends TestCase
{
    use WithFaker;

    public function testCanGetReglementInterieurs()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/reglements-interieursall')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanCreateMultipleReglementInterieurs()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $regles = [
            [
                'title' => $this->faker->text(25),
                'idSchool' => 1,
                'idSection' => 1,
                'type' => 'general',
                'image' => 'https://example.com/image.jpg',
                'description' => $this->faker->text(100),
            ],
            [
                'title' => $this->faker->text(25),
                'idSchool' => 1,
//                'idSection' => 1,
                'type' => 'general',
                'image' => 'https://example.com/image.jpg',
                'description' => $this->faker->text(100),
            ],
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/reglements-interieurs', [
                'reglements_interieurs' => $regles
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCannotCreateReglementInterieursWithMissingFields()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $regles = [
            [
                'title' => $this->faker->text(25),
//                'idSchool' => 1,
                'idSection' => 1,
                'type' => 'general',
                'image' => 'https://example.com/image.jpg',
                'description' => $this->faker->text(100),
            ],
            [
                'title' => $this->faker->text(25),
                'idSchool' => 1,
//                'idSection' => 1,
                'description' => $this->faker->text(100),
            ],
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/reglements-interieurs', [
                'reglements_interieurs' => $regles
            ])
            ->assertStatus(422);
    }

    public function testCannotCreateReglementInterieursWithoutparam()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/reglements-interieurs')
            ->assertStatus(422);
    }

    public function testCanUpdateReglementInterieur()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $regle = ReglementInterieur::latest()->first();

        $data = [
//            'title' => $this->faker->text(25),
//            'idSchool' => 1,
//            'idSection' => 1,
//            'description' => $this->faker->text(100),
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/reglements-interieurs/{$regle->id}", $data)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanTrashReglementInterieur()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $regle = ReglementInterieur::latest()->first();

        $regle->update([
            'deleted' => false
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->delete("/api/reglements-interieurs/trash/{$regle->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        // on remet à FALSE
        $regle->update([
            'deleted' => false
        ]);
    }

    public function testCanRestoreReglementInterieur()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $regle = ReglementInterieur::latest()->first();

        $regle->update([
            'deleted' => true,
            'deleted_by' => auth()->user()->id
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->post("/api/reglements-interieurs/restore/{$regle->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }
}
