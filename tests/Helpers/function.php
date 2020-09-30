<?php

use App\Models\Post;

function createPost($attribute=[])
{
    return Post::factory()->create($attribute);

}

?>
