<?php

namespace Tests\Unit\Documents;

use App\Models\User;
use Tests\TestCase;

class CertificatScolariteTest extends TestCase
{
    public function testCannotGenerateCertificatScolariteWithMissingClasse()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/users/generer-certificat-scolarite', [
                //'idClasse' => 56,
                "route" => "dev",
            ])
            ->assertStatus(422);
    }

    public function testCannotGenerateCertificatScolariteWithMissingRoute()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/users/generer-certificat-scolarite', [
                'idClasse' => 56,
                //"route" => "dev",
            ])
            ->assertStatus(422);
    }

    public function testCanGenerateCertificatScolariteForClasse()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/users/generer-certificat-scolarite', [
                'idClasse' => 56,
                "route" => "dev",
            ])
            ->assertStatus(200);

        // On vérifie que le fichier PDF est bien généré
        $this->assertMatchesRegularExpression(
            '/^https?:\/\/.+\.(zip)$/',
            $response->json('data')
        );
    }

    public function testCanGenerateCertificatScolariteForStudent()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/users/generer-certificat-scolarite', [
                'idClasse' => 56,
                "route" => "dev",
                "idStudent" => 1088
            ])
            ->assertStatus(200);

        // On vérifie que le fichier PDF est bien généré
        $this->assertMatchesRegularExpression(
            '/^https?:\/\/.+\.(pdf)$/',
            $response->json('data')
        );
    }

    public function testCanGenerateCertificatScolariteForStudentWithNoBirthday()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $student = User::find(1088);
        $student->update([
            'birthday' => null
        ]);
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/users/generer-certificat-scolarite', [
                'idClasse' => 56,
                "route" => "dev",
                "idStudent" => 1088
            ])
            ->assertStatus(200);

        // On vérifie que le fichier PDF est bien généré
        $this->assertMatchesRegularExpression(
            '/^https?:\/\/.+\.(pdf)$/',
            $response->json('data')
        );
    }

    public function testCanGenerateCertificatScolariteForStudentWithNoBirthplace()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $student = User::find(1088);
        $student->update([
            'placeofbirth' => null
        ]);
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/users/generer-certificat-scolarite', [
                'idClasse' => 56,
                "route" => "dev",
                "idStudent" => 1088
            ])
            ->assertStatus(200);

        // On vérifie que le fichier PDF est bien généré
        $this->assertMatchesRegularExpression(
            '/^https?:\/\/.+\.(pdf)$/',
            $response->json('data')
        );
    }

    public function testCanGenerateCertificatScolariteForStudentWithNoParent()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $student = User::find(1088);
        $idParent = $student->idParent; // on garde juste

        $student->update([
            'idParent' => null
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/users/generer-certificat-scolarite', [
                'idClasse' => 56,
                "route" => "dev",
                "idStudent" => 1088
            ])
            ->assertStatus(200);

        // On vérifie que le fichier PDF est bien généré
        $this->assertMatchesRegularExpression(
            '/^https?:\/\/.+\.(pdf)$/',
            $response->json('data')
        );

        // On remet ceci à sa place
        $student->update([
            'idParent' => $idParent
        ]);
    }

    public function testCanGenerateCertificatScolariteForStudentWithFathernameNull()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $student = User::find(1088);
        $parent = User::find($student->idParent);
        $student->update([
            'placeofbirth' => null
        ]);
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/users/generer-certificat-scolarite', [
                'idClasse' => 56,
                "route" => "dev",
                "idStudent" => 1088
            ])
            ->assertStatus(200);

        // On vérifie que le fichier PDF est bien généré
        $this->assertMatchesRegularExpression(
            '/^https?:\/\/.+\.(pdf)$/',
            $response->json('data')
        );
    }

    public function testCanGenerateCertificatScolariteForAkoumaHighSchool()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/users/generer-certificat-scolarite', [
                'idClasse' => 56,
                "route" => "abiscoms",
                "idStudent" => 1088
            ])
            ->assertStatus(200);

        // On vérifie que le fichier PDF est bien généré
        $this->assertMatchesRegularExpression(
            '/^https?:\/\/.+\.(pdf)$/',
            $response->json('data')
        );
    }
}
