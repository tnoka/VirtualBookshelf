<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class AccessTest extends TestCase
{
    use RefreshDatabase;
    
    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /**
     * @test
     */
    public function Access_正常にアクセスできるか()
    {
        $this->get('/')->assertOk();
        $this->get('/terms')->assertOk();
        $this->get('/privacy')->assertOk();
        $this->get('/products/search')->assertOk();
        $this->get('/users/all')->assertOk();
        $this->actingAs($this->user)->get('/followIndex/1')->assertOk();
        $this->actingAs($this->user)->get('/followerIndex/1')->assertOk();
        $this->actingAs($this->user)->get('/products/1')->assertOk();
        $this->actingAs($this->user)->put('/products/1')->assertOk();
        $this->actingAs($this->user)->post('/users/1/follow')->assertOk();
        $this->actingAs($this->user)->delete('/users/1/unFollow')->assertOk();
        $this->actingAs($this->user)->get('/favorites/1')->assertOk();
    }
}
