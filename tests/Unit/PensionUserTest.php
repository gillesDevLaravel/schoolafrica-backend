<?php

namespace Tests\Unit;

use App\Models\Level;
use App\Models\Pension;
use App\Models\PensionUser;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PensionUserTest extends TestCase
{
    use WithFaker;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    protected function getPension($idStudent){
        return Pension::select('pensions.name as name','pensions.price as price','pensions.nbrTranche as nbrTranche')
            ->join('levels','levels.id','=','pensions.idLevel')
            ->join('users','users.idLevel','=','pensions.idLevel')
            ->where('users.id', $idStudent)
            ->first();
    }

    public function testCanGetBalancePension()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $pension = Pension::select('pensions.id as id')
            ->join('users', 'pensions.idLevel', '=', 'users.idLevel')
            ->where('users.id', $this->idStudent)
            ->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/balancePension', [
                'idSchool' => 2,
                'idSection' => 2,
                "idStudent" => $this->idStudent,
                "idPension" => $pension->id
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'total',
                'alreadyPaid',
                'message',
            ]);
    }

    public function testCanGetBalancePensionWithBourse()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/balancePensionWithBourse', [
                "idStudent" => $this->idStudent
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'total',
                'alreadyPaid',
            ]);
    }

    public function testCannotGetBalancePensionWithBourseWithMissingidStudent()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/balancePensionWithBourse', [
//                "idStudent" => $this->idStudent
            ])
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'success'
            ]);
    }

    public function testUserCanPayPensionUser(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/pensionUsers', [
                'idSchool' => 2,
//                'idSection' => 2,
                "idStudent" => 927,
                "advancePayment" => 100,
                "payment_mode" => "TestCash"
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testUserCannotPayMoreThanPensionUserAmount(){
        // On va récupérer la pension de cet utilisateur et ajouter le montant pour ce rassurer qu'il ne peut pas payer celà
        $pension = Pension::select('pensions.name as name','pensions.price as price')
            ->join('levels','levels.id','=','pensions.idLevel')
            ->join('users','users.idLevel','=','pensions.idLevel')
            ->where('users.id', $this->idStudent)
            ->first();

        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/pensionUsers', [
                'idSchool' => 2,
                'idSection' => 2,
                "idStudent" => $this->idStudent,
                "advancePayment" => $pension->price + 1,
                "payment_mode" => "TestCash"
            ])
            ->assertStatus(404)
            ->assertJsonStructure([
                'success',
                'message',
            ]);
    }

    public function testUserCannotPayPensionUserWithMissingParameters(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/pensionUsers', [
                'idSchool' => 2,
                'idSection' => 2,
//                "idStudent" => $this->idStudent,
                "advancePayment" => 1,
                "payment_mode" => "TestCash"
            ])
            ->assertStatus(422)
            ->assertJsonStructure([
                'success',
                'message',
            ]);
    }

    public function testUserCannotPayPensionUserWithNegativeAmount(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/pensionUsers', [
                'idSchool' => 2,
                'idSection' => 2,
                "idStudent" => $this->idStudent,
                "advancePayment" => -1000,
                "payment_mode" => "TestCash"
            ])
            ->assertStatus(422)
            ->assertJsonStructure([
                'success',
                'message',
            ]);
    }

    public function testUserCanPayTheWholeSchoolFeeInOnce()
    {
        // On va récupérer la pension de cet utilisateur et ajouter le montant pour ce rassurer qu'il ne peut pas payer celà
        $pension = $this->getPension($this->idStudent);

        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

//        $receiptNumber = $this->faker->uuid;

        $resp = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/pensionUsers', [
                'idSchool' => 2,
                'idSection' => 2,
                "idStudent" => $this->idStudent,
                "advancePayment" => $pension->price,
                "payment_mode" => "TestCash",
//                "receiptNumber" => $receiptNumber
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'advancePayment',
                        'balancePayment',
                        'receiptNumber',
                        'operator',
                        'paymentDate',
                        'tranche',
                        'idPension',
                        'student',
                        'school',
                        'photo',
                        'idSection',
                        'bourse',
                        'created_at',
                    ]
                ]
            ]);

        // On va s'assurer que le nombre d'éléments crés correspond au nombre de tranches de la pension
        $resp->assertJsonCount($pension->nbrTranche, 'data');

        // on va vérifier quelques valeurs retournées pour s'assurer que l'enregistrement s'est bien effectué

//        $data = json_decode($resp->getContent(), true)['data'];

//        foreach ($data as $item) {
//            $this->assertEquals($receiptNumber, $item['receiptNumber']);
//        }
    }

    public function testCanDeletePensionUser()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $pensionUser = PensionUser::orderBy('id', 'desc')->first();
        $pensionUser->update([
            'deleted = false'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->delete("/api/pensionUsers/{$pensionUser->id}")
            ->assertStatus(200);

        $pensionUser->update([
            'deleted' => false
        ]);
    }
}
