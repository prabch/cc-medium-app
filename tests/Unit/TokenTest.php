<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Mediumtoken;

class TokenTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test User & Mediumtoken column token
     *
     * @return bool
     */
    public function test_user_token()
    {
        $user = User::factory()->create();
        $phone = Mediumtoken::factory()->create(['user_id' => $user->id]); 
        $this->assertInstanceOf(Mediumtoken::class, $user->token); 
        $this->assertEquals(1, $user->token->count()); 
    }
}