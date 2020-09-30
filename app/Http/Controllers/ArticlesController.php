<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article as ModelArticle;

class ArticlesController extends Controller
{
    public function add(){
        ModelArticle::factory()->count(2)->create();
        ModelArticle::factory()->create(['reads'=>10]);
        $mostPopular = ModelArticle::factory()->create(['reads'=>20]);

        return $mostPopular;
    }
}
