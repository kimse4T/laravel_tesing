<?php

namespace Tests\Feature;

use App\Models\Article as ModelArticle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ArticleTest extends TestCase
{

    use RefreshDatabase;
    //use DatabaseTransactions;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_fetches_treding_articles()
    {
        ModelArticle::factory()->count(2)->create();
        ModelArticle::factory()->create(['reads'=>10]);
        $mostPopular = ModelArticle::factory()->create(['reads'=>20]);
        $articles = ModelArticle::Trending();
        $this->assertEquals($mostPopular->id,$articles->first()->id);
    }
}
