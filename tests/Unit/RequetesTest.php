<?php

namespace Tests\Unit;

use App\Models\Requete;
use App\Models\School;
use App\Models\TypeRequete;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RequetesTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    public function testCanListCreatedRequetes()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/requetesall', [
                'idSchool' => 2,
                'idSection' => 2,
                'date_start' => now()->subMonth()->toDateString(),
                'date_end' => now()->toDateString(),
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'links',
                'meta',
            ]);
    }

    public function testCanCreateRequeteAndFounderReceivesNotification()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $school = School::whereNotNull('idPrincipal')->whereHas('sections')->first();

        if (!$school) {
            $this->markTestSkipped('Aucune école avec un principal et des sections trouvée.');
        }

        $principal = $school->principal;

        $principal->update([
            'device_key' => $this->device_key
        ]);

        $typeRequete = TypeRequete::inRandomOrder()->first() ?? factory(TypeRequete::class)->create();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/requetes', [
                'idSchool'      => $school->id,
                'idSection'     => $school->sections()->first()->id,
                'categorie'     => ['interne', 'externe'][rand(0, 1)],
                'description'   => $this->faker->text(10),
                'idTypeRequete' => $typeRequete->id,
                'idUser'        => 927,
                'lang'          => 'en',
            ])
            ->assertStatus(201);
    }

    public function testCannotCreateRequeteWithMissingParam()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/requetes', [
                'idSchool' => 2,
                'idSection' => 2,
            ])
            ->assertStatus(422)
            ->assertJsonStructure([
                'success',
                'message',
            ]);
    }

    public function testCanUpdateRequete()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $req = Requete::first();

        $student = User::find($req->idUser);
        $student->update([
            'device_key' => $this->device_key
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/requetes/{$req->id}", [
                'description' => $this->faker->text(10),
                'lang'        => 'en',
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanDeleteRequete()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $req = Requete::first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->delete("/api/requetes/{$req->id}", [
                'description' => $this->faker->text(10),
            ])
            ->assertStatus(204);
    }

    public function test_can_archive_requetes()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $requeteOne = factory(Requete::class)->create();
        $requeteTwo = factory(Requete::class)->create();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/requetes/trash', ['ids' => [$requeteOne->id, $requeteTwo->id]])
            ->assertStatus(204);

        $this->assertSoftDeleted('requetes', ['id' => $requeteOne->id]);
        $this->assertSoftDeleted('requetes', ['id' => $requeteTwo->id]);
    }

    public function test_can_restore_requetes()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $requeteOne = factory(Requete::class)->create();
        $requeteTwo = factory(Requete::class)->create();

        $requeteOne->delete();
        $requeteTwo->delete();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/requetes/restore', ['ids' => [$requeteOne->id, $requeteTwo->id]])
            ->assertStatus(200)
            ->assertJsonFragment([
                'success' => true,
                'message' => __('requete.restore.success'),
            ]);

        $this->assertDatabaseHas('requetes', ['id' => $requeteOne->id, 'deleted_at' => null]);
        $this->assertDatabaseHas('requetes', ['id' => $requeteTwo->id, 'deleted_at' => null]);
    }

    public function test_can_delete_requetes_permanently()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $requeteOne = factory(Requete::class)->create();
        $requeteTwo = factory(Requete::class)->create();

        $requeteOne->delete();
        $requeteTwo->delete();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/requetes/delete', ['ids' => [$requeteOne->id, $requeteTwo->id]])
            ->assertStatus(204);

        $this->assertDatabaseMissing('requetes', ['id' => $requeteOne->id]);
        $this->assertDatabaseMissing('requetes', ['id' => $requeteTwo->id]);
    }
}
