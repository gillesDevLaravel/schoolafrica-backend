<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\PageLivre;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PageLivreTest extends TestCase
{
    use WithFaker;

    public function testCanGetPagesOfABook()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/pages-livresall", [
                'idBook' => rand(1, Book::count())
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCannotGetPagesWithoutSpecifyingTheBook()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/pages-livresall", [
//                'idBook' => rand(1, Book::count())
            ])
            ->assertStatus(422);
    }

    public function testCanCreatePagesOfABook()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $data = [
            'idBook' => rand(1, Book::count()),
            'pages' => [
                [
                    'titre' => $this->faker->word(),
                    'sous_titre' => $this->faker->word(),
                    'description' => $this->faker->sentence(),
                ],
                [
                    'titre' => $this->faker->word(),
                    'sous_titre' => $this->faker->word(),
                    'description' => $this->faker->sentence(),
                ],
                [
                    'titre' => $this->faker->word(),
                    'sous_titre' => $this->faker->word(),
                    'description' => $this->faker->sentence(),
                ],
                [
                    'titre' => $this->faker->word(),
                    'sous_titre' => $this->faker->word(),
                    'description' => $this->faker->sentence(),
                ],
                [
                    'titre' => $this->faker->word(),
                    'sous_titre' => $this->faker->word(),
                    'description' => $this->faker->sentence(),
                ]
            ]
        ];

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson("/api/pages-livres", $data)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanUpdatePageBook()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $page = PageLivre::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->putJson("/api/pages-livres/{$page->id}", [
                'titre' => $this->faker->word(),
                'sous_titre' => $this->faker->word(),
                'description' => $this->faker->sentence(),
                'idBook' => rand(1, Book::count())
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }

    public function testCanTrashPageBook()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $page = PageLivre::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->delete("/api/pages-livres/trash/{$page->id}")
            ->assertStatus(200);
    }

    public function testCannotTrashATrashedPage()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $page = PageLivre::latest()->first();
        $page->update([
            'deleted' => true,
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->delete("/api/pages-livres/trash/{$page->id}")
            ->assertStatus(404);
    }

    public function testCanRestoreTrashedPage()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $page = PageLivre::latest()->first();
        $page->update([
            'deleted' => true,
        ]);

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->post("/api/pages-livres/restore/{$page->id}")
            ->assertStatus(200);
    }

    public function testCannotRestoreUnTrashedPage()
    {
        $login = parent::login([
            'username' => 'parentdev',
            'password' => '000000'
        ]);

        $page = PageLivre::latest()->first();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->post("/api/pages-livres/restore/{$page->id}")
            ->assertStatus(404);
    }
}
