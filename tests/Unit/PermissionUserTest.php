<?php

namespace Tests\Unit;

use App\Models\PermissionUser;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PermissionUserTest extends TestCase
{
    use WithFaker;

    private static $permissionId;

    private function getOrCreatePermissionId()
    {
        if (!self::$permissionId) {
            $permission = PermissionUser::create([
                "raison" => "Demande de congé d'une semaine",
                "depart" => "2025-02-05",
                "retour" => "2025-02-10",
                "duration" => 100,
                "status" => null,
                'idUser' => auth()->user()->id,
                'updated_by' => null,
            ]);

            self::$permissionId = $permission->id;
        }

        return self::$permissionId;
    }

    public function testCanStorePermissionUser()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token
        ])->post("/api/permissions-users", [
            "raison" => "Demande de congé d'une semaine",
            "dateDepart" => "2025-10-05",
            "dateRetour" => "2025-10-10",
            "duration" => 100,
            "status" => null,
            "idUserApprove" => User::inRandomOrder()->first()->id
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => __("permission_users.create.success"),
        ]);

        self::$permissionId = $response->json('data.id');

        // Vérification en base de données
        $this->assertDatabaseHas('permissions_users', [
            'id' => self::$permissionId,
            'raison' => "Demande de congé d'une semaine",
            "duration" => 100,
        ]);
    }

    public function testCanUpdatePermissionUser()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000',
        ]);

        $permissionId = $this->getOrCreatePermissionId();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token
        ])->put("/api/permissions-users/" . $permissionId, [
            "raison" => "Demande de congé prolongé",
            "duration" => 50
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => __("permission_users.update.success"),
        ]);

        $this->assertDatabaseHas('permissions_users', [
            'id' => $permissionId,
            'raison' => "Demande de congé prolongé",
            "duration" => 50
        ]);
    }

    public function testCanTrashPermissionUser()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000',
        ]);

        $permissionId = $this->getOrCreatePermissionId();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token
        ])->delete("/api/permissions-users/trash/" . $permissionId);

        $response->assertStatus(200);
        $response->assertJson([
            "success" => true,
            'message' => __("permission_users.trash.success"),
        ]);

        $this->assertSoftDeleted('permissions_users', [
            'id' => $permissionId
        ]);
    }

    public function testCanRestorePermissionUser()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000',
        ]);

        $permissionId = $this->getOrCreatePermissionId();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token
        ])->post("/api/permissions-users/restore/" . $permissionId);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => __("permission_users.restore.success"),
        ]);

        $this->assertDatabaseHas('permissions_users', [
            'id' => $permissionId
        ]);
    }

    public function testCanDeletePermissionUserTrashed()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000',
        ]);

        $permissionId = $this->getOrCreatePermissionId();

        //on met dans la corbeille pour le test
        $this->withHeaders([
            'Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token
        ])->delete("/api/permissions-users/trash/" . $permissionId);

        //On tente une suppression
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token
        ])->delete("/api/permissions-users/delete/" . $permissionId);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => __("permission_users.destroy.success"),
        ]);

        $this->assertDatabaseMissing('permissions_users', [
            'id' => $permissionId
        ]);
    }
}
