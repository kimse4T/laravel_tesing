<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;
use App\Models\Like as ModelLike;
use App\Models\User;
use Tests\Feature\test;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */

    protected $post;


    public function setUp():void{

        parent::Setup();

        $this->post =  Post::factory()->create();

        //$this->post=createPost();

        $this->signIn();

    }

    /** @test */
    public function a_user_can_like_a_post()
    {


        $this->post->like();

        $this->assertDatabaseHas('likes',[
            'user_id'   => $this->user->id,
            'likeable_id'   => $this->post->id,
            'likeable_type' => get_class($this->post),
        ]);

        $this->assertTrue($this->post->isLiked());
    }

    /** @test */
    public function a_user_can_unlike_a_post()
    {

        $this->post->like();
        $this->post->unlike();

        $this->assertDatabaseMissing('likes',[
            'user_id'   => $this->user->id,
            'likeable_id'   => $this->post->id,
            'likeable_type' => get_class($this->post),
        ]);

        $this->assertFalse($this->post->isLiked());
    }

    /** @test */
    public function a_user_can_toggle_like()
    {

        $this->post->toggle();

        $this->assertFalse($this->post->isLiked());
    }

    /** @test */
    public function a_post_can_count_likes()
    {

        $this->post->like();

        $this->assertEquals(1,$this->post->LikesCount);
    }


}
