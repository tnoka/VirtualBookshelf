<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class DestroyUserApiTest extends TestCase
{
    public function setUp():void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();      
    }
    
    /**
     * @test
     */
    public function DestroyUser_ユーザーを削除できる()
    {
        $response = $this->actingAs($this->user)
            ->json('DELETE', route('user.delete', [
                'id' => $this->user->id,
            ]));

        $response->assertStatus(200);

        $users = User::all();

        $this->assertEquals(0, $users->count());
    }
}
