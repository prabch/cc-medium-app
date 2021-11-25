<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test inserts to posts table
     *
     * @return bool
     */
    public function test_post_creation()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]); 
        $this->assertTrue(is_numeric($post->id)); 
    }
}