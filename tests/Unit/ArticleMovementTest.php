<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\ArticleMovement;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ArticleMovementTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_filter_article_movements_by_date_range()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $token = json_decode($login->getContent())->data->token;
        $article = factory(Article::class)->create();

        $movementInRange = factory(ArticleMovement::class)->create([
            'article_id' => $article->id,
            'created_at' => now()->subDays(2),
            'updated_at' => now()->subDays(2),
        ]);

        $movementOutRange = factory(ArticleMovement::class)->create([
            'article_id' => $article->id,
            'created_at' => now()->subDays(10),
            'updated_at' => now()->subDays(10),
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/article-movementsall', [
                'article_id' => $article->id,
                'date_start' => now()->subDays(3)->toDateString(),
                'date_end' => now()->subDay()->toDateString(),
            ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $movementInRange->id])
            ->assertJsonMissing(['id' => $movementOutRange->id]);
    }

    public function test_can_archive_article_movements()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $movementOne = factory(ArticleMovement::class)->create();
        $movementTwo = factory(ArticleMovement::class)->create();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/article-movements/trash', ['ids' => [$movementOne->id, $movementTwo->id]])
            ->assertStatus(204);

        $this->assertSoftDeleted('article_movements', ['id' => $movementOne->id]);
        $this->assertSoftDeleted('article_movements', ['id' => $movementTwo->id]);
    }

    public function test_can_restore_article_movements()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $movementOne = factory(ArticleMovement::class)->create();
        $movementTwo = factory(ArticleMovement::class)->create();

        $movementOne->delete();
        $movementTwo->delete();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/article-movements/restore', ['ids' => [$movementOne->id, $movementTwo->id]])
            ->assertStatus(200)
            ->assertJsonFragment([
                'success' => true,
                'message' => __('articlemovement.restore.success'),
            ]);

        $this->assertDatabaseHas('article_movements', ['id' => $movementOne->id, 'deleted_at' => null]);
        $this->assertDatabaseHas('article_movements', ['id' => $movementTwo->id, 'deleted_at' => null]);
    }

    public function test_can_delete_article_movements_permanently()
    {
        $login = parent::login([
            'username' => 'fondateur',
            'password' => '000000'
        ]);

        $movementOne = factory(ArticleMovement::class)->create();
        $movementTwo = factory(ArticleMovement::class)->create();

        $movementOne->delete();
        $movementTwo->delete();

        $this->withHeaders(['Authorization' => 'Bearer ' . json_decode($login->getContent())->data->token])
            ->postJson('/api/article-movements/delete', ['ids' => [$movementOne->id, $movementTwo->id]])
            ->assertStatus(204);

        $this->assertDatabaseMissing('article_movements', ['id' => $movementOne->id]);
        $this->assertDatabaseMissing('article_movements', ['id' => $movementTwo->id]);
    }
}
