<?php

namespace Tests\Feature;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LikesTest extends TestCase
{
    use DatabaseTransactions;

    protected Post $post;

    public function setUp(): void
    {
        parent::setUp();

        $this->post = Post::factory()->create();

        $this->signIn();
    }

    public function test_user_can_like_a_post()
    {
        $this->post->like();

        $this->assertDatabaseHas(Like::class, [
            'user_id' => $this->user->id,
            'likeable_id' => $this->post->id,
            'likeable_type' => $this->post::class,
        ]);

        $this->assertTrue($this->post->isLiked());
    }

    public function test_user_can_unlike_a_post()
    {
        $this->post->like();
        $this->post->unlike();

        $this->assertDatabaseMissing(Like::class, [
            'user_id' => $this->user->id,
            'likeable_id' => $this->post->id,
            'likeable_type' => $this->post::class,
        ]);

        $this->assertFalse($this->post->isLiked());
    }

    public function test_user_can_toggle_post_like_status()
    {
        $this->post->toggle();

        $this->assertTrue($this->post->isLiked());

        $this->post->toggle();

        $this->assertFalse($this->post->isLiked());
    }

    public function test_post_knows_how_many_likes_it_has()
    {
        $this->post->toggle();

        $this->assertEquals(1, $this->post->likesCount);
    }
}
