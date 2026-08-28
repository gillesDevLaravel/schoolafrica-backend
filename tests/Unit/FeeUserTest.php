<?php

namespace Tests\Unit;

use App\Models\Fee;
use App\Models\FeeUser;
use App\Models\Pension;
use App\Models\PensionUser;
use Tests\TestCase;
use function PHPUnit\Framework\isNull;

class FeeUserTest extends TestCase
{
    public function testCanGetFeeUsers(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/feeusersall', [
                'idSchool' => 2,
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'meta',
                'sommes',
                'om',
                'cash',
                'bank',
            ]);
    }

    public function testCanPayFee(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        FeeUser::where([
            "idStudent"=> 42,
            "idFee"=> 2,
        ])->delete();

        $r = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/feeusers', [
                "payment_mode"=> "Cash",
                "advancePayment"=> 10,
                "idStudent"=> 42,
                "idFee"=> 2,
                "idLevel"=> 6,
//                "idSection"=> 1,
                "idSchool"=> 1
            ])
            ->assertStatus(200);
    }

    public function testCannotPayFeeWithInvalidIdStudent(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/feeusers', [
                "payment_mode"=> "Cash",
                "advancePayment"=> 10,
                "idStudent"=> 42000,
                "idFee"=> 2,
                "idLevel"=> 6,
                "idSection"=> 1,
                "idSchool"=> 1
            ])
            ->assertStatus(404)
            ->assertJsonStructure([
                "success",
                "message",
//                "data"
            ]);
    }


    public function testCannotPayFeeWithMissingIdStudent(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/feeusers', [
                "payment_mode"=> "Cash",
                "advancePayment"=> 10,
                //"idStudent"=> 42000,
                "idFee"=> 2,
                "idLevel"=> 6,
                "idSection"=> 1,
                "idSchool"=> 1
            ])
            ->assertStatus(422)
            ->assertJsonStructure([
                "success",
                "message"
            ]);
    }

    public function testCannotPayFeeAlreadyPaid(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $fee = Fee::find(2);

        FeeUser::where([
            "idStudent"=> 42,
            "idFee"=> 2,
        ])->delete();

        // On paie tout
        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/feeusers', [
                "payment_mode"=> "Cash",
                "advancePayment"=> $fee->price,
                "idStudent"=> 42,
                "idFee"=> 2,
                "idLevel"=> 6,
                "idSection"=> 1,
                "idSchool"=> 1
            ])
            ->assertStatus(200);

        // On vérifie qu'il ne peut plus rien payer ... même pas 1f
        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/feeusers', [
                "payment_mode"=> "Cash",
                "advancePayment"=> 1,
                "idStudent"=> 42,
                "idFee"=> 2,
                "idLevel"=> 6,
                "idSection"=> 1,
                "idSchool"=> 1
            ])
            ->assertStatus(500);
    }

    public function testCannotPayMoreThanTheFeeAmount(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/feeusers', [
                "payment_mode"=> "Cash",
                "advancePayment"=> 9999999999,
                "idStudent"=> 42,
                "idFee"=> 2,
                "idLevel"=> 6,
                "idSection"=> 1,
                "idSchool"=> 1
            ])
            ->assertStatus(500);
    }

    public function testCanDeleteFeeUser()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $fee_user = FeeUser::orderBy('id', 'DESC')->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->delete("/api/feeusers/$fee_user->id")
            ->assertStatus(200);

        $fee_user->update([
            'deleted' => false
        ]);
    }
}
