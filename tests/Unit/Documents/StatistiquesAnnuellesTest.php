<?php

namespace Tests\Unit\Documents;

use App\Models\Classes;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class StatistiquesAnnuellesTest extends TestCase
{
    use DatabaseTransactions;

    private function getAuthHeaders(): array
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $token = json_decode($login->getContent())->data->token;

        return ['Authorization' => 'Bearer ' . $token];
    }

    private function getAnyClasse(): Classes
    {
        $classe = Classes::query()
            ->whereNotNull('idSchool')
            ->whereNotNull('idLevel')
            ->whereNotNull('idSection')
            ->inRandomOrder()
            ->first();

        $this->assertNotNull($classe, 'Aucune classe valide trouvée pour le test.');

        return $classe;
    }

    public function testStatistiquesAnnuellesBySchool()
    {
        $classe = $this->getAnyClasse();
//        dd($classe->school);

        $response = $this->withHeaders($this->getAuthHeaders())
            ->postJson('/api/statistiques-annuelles-maternelle-primaire', [
                'idSchool' => $classe->idSchool,
            ]);
        dd($response->getContent());
        $response->assertStatus(200)
            ->assertJsonStructure([
                'sequences',
                'trimestres',
            ]);
    }

    public function testStatistiquesAnnuellesByLevel()
    {
        $classe = $this->getAnyClasse();

        $response = $this->withHeaders($this->getAuthHeaders())
            ->postJson('/api/statistiques-annuelles-maternelle-primaire', [
                'idLevel' => $classe->idLevel,
            ]);
        dd($response->getContent());
        $response->assertStatus(200)
            ->assertJsonStructure([
                'sequences',
                'trimestres',
            ]);
    }

    public function testStatistiquesAnnuellesByClasse()
    {
        $classe = $this->getAnyClasse();

        $response = $this->withHeaders($this->getAuthHeaders())
            ->postJson('/api/statistiques-annuelles-maternelle-primaire', [
                'idClasse' => $classe->id,
            ]);
        dd($response->getContent());
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'sequences',
                'trimestres',
            ]);
    }
}
