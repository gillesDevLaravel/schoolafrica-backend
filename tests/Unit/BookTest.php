<?php

namespace Tests\Unit;

use App\Models\Book;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookTest extends TestCase
{
    use WithFaker;

    public function testCanGetBooks(){
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/booksall')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanCreateBook()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/books', [
                'name' => $this->faker->name
            ])
            ->assertStatus(201)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanUpdateBook()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $bo = Book::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/books/{$bo->id}", [
                'name' => $this->faker->name,
                'auteur' => $this->faker->name,
                'edituer' => $this->faker->name,
                'date_publication' => $this->faker->date(),
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanDeleteBook()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $bo = Book::latest()->first();

        if(!is_null($bo)){
            $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
                ->deleteJson("/api/books/{$bo->id}")
                ->assertStatus(200);
        }

        $bo->update([
            'deleted' => false,
            'deleted_by' => null
        ]);
    }
}
