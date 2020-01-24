<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Product;
use App\User;
use App\Comment;


class DestroyCommentApiTest extends TestCase
{

    use RefreshDatabase;

    public function setup(): void
    {
        parent::setup();

        $this->user = factory(User::class)->create;
    }

    /**
     * @test
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
