<?php

namespace Tests\Unit;

use App\Http\Resources\ContractResource;
use App\Models\Contract;
use App\Models\PermissionUser;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContractTest extends TestCase
{
    use WithFaker;

    private static $contractId;

    private function getOrCreateContractId()
    {
        if (!self::$contractId) {


            $user = User::inRandomOrder()->first()->id;

            Contract::where('idUser', $user)->where('status', '!=', 'terminated')->delete();

            $contract = Contract::create([
                "idUser" => $user,
                "idUserApprove" => auth()->id(),
                "reference" => generateReferenceNumber(Contract::class, "reference", 6),
                "type" => "CDD",
                "description" => null,
                "start_date" => now()->toDateString(),
                "duration" => 12,
                "working_hours" => "8:00-17:00",
                "position" => "Développeur",
                "gross_salary" => 3500,
                "status" => "pending_approval",
                "service_benefits" => "Tickets restaurant",
                "bonus" => null,
                "created_by" => auth()->id()
            ]);

            self::$contractId = $contract->id;
        }

        return self::$contractId;
    }

    public function testCanStoreContract()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000',
        ]);

        $user = User::inRandomOrder()->first()->id;

        Contract::where('idUser', $user)->where('status', '!=', 'terminated')->delete();

        $payload = [
            "idUser" => $user,
            "idUserApprove" => auth()->id(),
            "type" => "CDD",
            "description" => null,
            "start_date" => now()->toDateString(),
            "duration" => 12,
            "working_hours" => "8:00-17:00",
            "position" => "Développeur",
            "gross_salary" => 3500,
            "status" => null,
            "service_benefits" => "Tickets restaurant",
            "file" => "Tickets",
            "bonus" => null,
            'number_days_off' => 14,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token
        ])->post("/api/contracts", $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => __("contracts.create.success"),
        ]);

        self::$contractId = $response->json('data.id');

        $this->assertDatabaseHas('contracts', [
            'id' => self::$contractId,
            'type' => $payload['type'],
            'start_date' => $payload['start_date'],
            'duration' => $payload['duration'],
            'working_hours' => $payload['working_hours'],
            'position' => $payload['position'],
            'gross_salary' => $payload['gross_salary'],
            'status' => $payload['status'] ?? "pending_approval",
            'service_benefits' => $payload['service_benefits'],
            'number_days_off' => $payload['number_days_off'],
        ]);
    }

    public function testCanUpdateContract()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000',
        ]);

        $contractId = $this->getOrCreateContractId();

        $user = User::inRandomOrder()->first()->id;

        $contract = Contract::where('idUser', $user)->where('status', '!=', 'terminated')->delete();

        if ($contract) {
            $contract->delete();
        }

        $payload = [
            "idUser" => $user, // Prend un utilisateur aléatoire ou 1 par défaut
            "type" => ["CDD", "CDI", "Stage"][array_rand(["CDD", "CDI", "Stage"])],
            "description" => $this->faker->sentence,
            "start_date" => now()->toDateString(),
            "duration" => rand(1, 24),
            "working_hours" => ["8:00-17:00", "9:00-18:00", "10:00-19:00"][array_rand(["8:00-17:00", "9:00-18:00", "10:00-19:00"])],
            "position" => "Développeur",
            "gross_salary" => rand(2500, 7000),
            "status" => ['pending_approval','approved','terminated'][array_rand(['pending_approval','approved','terminated'])],
            "service_benefits" => ["Tickets restaurant", "Mutuelle", "Voiture de fonction"][array_rand(["Tickets restaurant", "Mutuelle", "Voiture de fonction"])],
            "bonus" => null,
            "file" => "Tickets",
            'number_days_off' => 14,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token
        ])->put("/api/contracts/" . $contractId, $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => __("contracts.update.success"),
        ]);

        $this->assertDatabaseHas('contracts', [
            'id' => self::$contractId,
            'type' => $payload['type'],
            'start_date' => $payload['start_date'],
            'duration' => $payload['duration'],
            'working_hours' => $payload['working_hours'],
            'position' => $payload['position'],
            'gross_salary' => $payload['gross_salary'],
            'status' => $payload['status'],
            'service_benefits' => $payload['service_benefits'],
            'number_days_off' => $payload['number_days_off'],
        ]);
    }

    public function testCanTrashContract()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000',
        ]);

        $contractId = $this->getOrCreateContractId();

        $payload = [
            "ids" => [$contractId]
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token
        ])->postJson("/api/contracts/trash", $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => null,
            'message' => __("contracts.trash.success"),
        ]);

        $this->assertDatabaseHas('contracts', [
            'id' => self::$contractId,
            'deleted' => true,
        ]);
    }

    public function testCanRestorePermissionUser()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000',
        ]);

        $contractId = $this->getOrCreateContractId();

//        $contract = Contract::findOrFail(self::$contractId);
//        $contract->update([
//            "deleted" => true
//        ]);

        $payload = [
            "ids" => [$contractId]
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token
        ])->post("/api/contracts/restore", $payload);



        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => __("contracts.restore.success"),
        ]);

        $this->assertDatabaseHas('contracts', [
            'id' => self::$contractId,
            'deleted' => false,
        ]);
    }

    public function testCanDeleteContractTrashed()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000',
        ]);

        $contractId = $this->getOrCreateContractId();

        // On met le contrat à la corbeille
        $contract = Contract::findOrFail(self::$contractId);
        $contract->update([
            "deleted" => true
        ]);

        $payload = [
            "ids" => [$contractId]
        ];

        // Suppression définitive
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token
        ])->postJson("/api/contracts/delete", $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => __("contracts.destroy.success"),
        ]);

        $this->assertDatabaseMissing('contracts', [
            'id' => $contractId
        ]);
    }
}
