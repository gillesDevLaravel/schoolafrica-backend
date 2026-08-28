<?php

namespace Tests\Unit;

use App\Models\Event;
use App\Models\Section;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class EventTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_filter_events_by_date_range()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $token = json_decode($login->getContent())->data->token;
        $section = Section::first();

        $this->assertNotNull($section);

        $eventInRange = Event::create([
            'name' => 'Event in range',
            'description' => 'Test description',
            'startDate' => now()->subDays(2)->toDateString(),
            'endDate' => now()->subDay()->toDateString(),
            'type' => 'interne',
            'idSchool' => $section->idSchool,
            'idSection' => $section->id,
            'created_by' => json_decode($login->getContent())->data->id ?? null,
        ]);

        $eventOutRange = Event::create([
            'name' => 'Event out of range',
            'description' => 'Test description',
            'startDate' => now()->subDays(10)->toDateString(),
            'endDate' => now()->subDays(9)->toDateString(),
            'type' => 'interne',
            'idSchool' => $section->idSchool,
            'idSection' => $section->id,
            'created_by' => json_decode($login->getContent())->data->id ?? null,
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/eventsall', [
                'idSchool' => $section->idSchool,
                'date_start' => now()->subDays(3)->toDateString(),
                'date_end' => now()->subDay()->toDateString(),
            ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $eventInRange->id])
            ->assertJsonMissing(['id' => $eventOutRange->id]);
    }
}
