<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\Database\Migrations;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Product;
use App\User;
use App\Comment;

class AddCommentApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        Auth::loginUsingId($this->user->id);
    }
    /**
     * @test
     */
    public function Comment_コメントを追加できるか()
    {
        factory(Product::class)->create();
        $this->product = Product::first();

        $response = $this->json('POST',(route('comments.store', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'text' => 'Sample'
        ])));

        $comments = Comment::first();

        $response->assertStatus(201);

        // DBにコメントが１件登録されているか
        $this->assertEquals(1, $comments->count());
        // 内容がAPIでリクエストしたものと一致するか
        $this->assertEquals($text, $comments[0]->text);
    }
}
