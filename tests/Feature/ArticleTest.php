<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_fetches_trending_articles()
    {
        Article::factory(3)->create();
        Article::factory()->create(['reads' => 10]);
        $mostPopular = Article::factory()->create(['reads' => 20]);

        $articles = Article::trending()->get();

        $this->assertEquals($mostPopular->id, $articles->first()->id);
        $this->assertCount(3, $articles);
    }
}
