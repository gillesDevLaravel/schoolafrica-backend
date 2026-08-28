<?php

namespace Tests;

use App\Models\FeeUser;
use App\Models\PensionUser;
use App\Models\User;
use App\Traits\ManageDirectoryTrait;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    use ManageDirectoryTrait;

    protected $idStudent;

    public function setUp(): void
    {
        parent::setUp();

        $this->idStudent = 927;
        $this->idClasse = 10;
        $this->device_key = "";
//        $this->device_key = "";

//        $this->copyDatabase();

        PensionUser::where('idStudent', $this->idStudent)->delete();
        FeeUser::where('idStudent', $this->idStudent)->delete();
    }

    public function login($user)
    {
        return $this->postJson('/api/login',
            [
                'username' => $user['username'],
                'password' => $user['password']
            ]
        );
    }

    protected function assertResponseStatus($response, $expectedStatus)
    {
        if ($response->status() !== $expectedStatus) {
            $this->fail("Expected status $expectedStatus but received {$response->status()}.\nResponse: " . $response->getContent());
        }
    }

    public function tearDown(): void
    {
        // Code pour nettoyer ou supprimer des ressources
        // Par exemple, supprimer un dossier ou une base de données temporaire
        parent::tearDown();

//        $this->deleteDirectory('pdfs');
    }

    public function unsetDeviceKey($idUser)
    {
        User::find($idUser)->update([
            'device_key' => null
        ]);
    }

//    protected function copyDatabase()
//    {
//        $sourceDb = env('u989816557_dev');
//        $targetDb = env('u989816557_test_dev');
//        $username = env('root');
//        $password = env('password');
//
//        $command = "mysqldump -u {$username} -p{$password} {$sourceDb} | mysql -u {$username} -p{$password} {$targetDb}";
//
//        exec($command);
//    }
}
