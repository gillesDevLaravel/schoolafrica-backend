<?php

namespace Tests\Unit;

use App\Enums\StatusEnum;
use App\Models\Contract;
use App\Models\Holiday;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HolidayTest extends TestCase
{
    use WithFaker;

    public function test_can_list_holidays(){
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/holidaysall')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_can_create_holidays()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $holiday_types = ['maladie', 'fête', 'grossesse', 'congé annuel'];

        //on update d'abord le nombre de jours de congés
        $user = User::where('username', 'fondateur')->first();
        if(Contract::where('idUser', $user->id)->where('status', 'approved')->count() === 0) {
            $contract = factory(Contract::class)->create([
                'idUser' => $user->id,
                'number_days_off' => 30,
                'status' => 'approved'
            ]);
        }else{
            $contract = Contract::where('idUser', $user->id)->where('status', 'approved')->first();

            if ($contract) {
                $contract->number_days_off = 30;  // Remplace $newDuration par la nouvelle durée
                $contract->save();
            }
        }
        $user->save();
        $user->refresh();

        $holiday_details = [
            'type' => $holiday_types[rand(0, count($holiday_types)-1)],
            'start_date' => "2030-04-05",
            'end_date' => "2030-04-10",
            'days_taken' => rand(10,25),
            'reason' => $this->faker->text,
            'idUserApprove' => User::inRandomOrder()->first()->id,
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/holidays', $holiday_details)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function test_cannot_create_holiday_if_not_enough_remaining_days_off()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $holiday_types = ['maladie', 'fête', 'grossesse', 'congé annuel'];

        //on update d'abord le nombre de jours de congés
        $user = User::where('username', 'fondateur')->first();

        if(Contract::where('idUser', $user->id)->where('status', 'approved')->count() === 0) {
            $contract = factory(Contract::class)->create([
                'idUser' => $user->id,
                'number_days_off' => 0,
                'status' => 'approved'
            ]);
        }else{
            $contract = Contract::where('idUser', $user->id)->where('status', 'approved')->first();

            if ($contract) {
                $contract->number_days_off = 0;  // Remplace $newDuration par la nouvelle durée
                $contract->save();
            }
        }
        $user->save();
        $user->refresh();

        $holiday_details = [
            'type' => $holiday_types[rand(0, count($holiday_types)-1)],
            'start_date' => "2030-04-05",
            'end_date' => "2030-04-10",
            'days_taken' => 60,
            'reason' => $this->faker->text,
            'idUserApprove' => User::inRandomOrder()->first()->id,
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/holidays', $holiday_details);

            $response->assertStatus(404);
    }

    public function test_can_update_holiday()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $holiday = factory(Holiday::class)->create([
            'idUser' => auth()->user()->id
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/holidays/{$holiday->id}", [
                'days_taken' => rand(1,5),
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        $holiday->delete();
    }

//    public function test_cannot_update_an_approved_or_rejected_holiday()
    public function test_cannot_update_an_approved_holiday()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $holiday = factory(Holiday::class)->create([
            'idUser' => auth()->user()->id,
            'status' => $this->faker()->randomElement([StatusEnum::APPROVED])
//            'status' => $this->faker()->randomElement([StatusEnum::APPROVED, StatusEnum::REJECTED])
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/holidays/{$holiday->id}", [
                'days_taken' => rand(1,5),
            ])
            ->assertStatus(404);

        $holiday->delete();
    }

    public function test_can_trash_holidays()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $holidays = factory(Holiday::class, 5)->create();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/holidays/trash", [
                'idHolidays' => $holidays->pluck('id')->toArray()
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);

        collect($holidays)->each(function ($holiday) {
            $holiday->delete();
        });
    }

    public function test_can_restore_holidays()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $holidays = factory(Holiday::class, 5)->create([
            'deleted' => 1
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/holidays/restore", [
                'idHolidays' => $holidays->pluck('id')->toArray()
            ])
            ->assertStatus(200);

        collect($holidays)->each(function ($holiday) {
            $holiday->delete();
        });
    }

    public function test_can_delete_holidays()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $holidays = factory(Holiday::class, 5)->create([
            'deleted' => 1
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/holidays/delete", [
                'idHolidays' => $holidays->pluck('id')->toArray()
            ])
            ->assertStatus(200);
    }
}
