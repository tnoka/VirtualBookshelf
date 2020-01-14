<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
Use App\Product;
Use App\User;

class AddCommentApiTest extends TestCase
{
    use RefreshDatabase;
    
    public function setUp():void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }
    /**
     * @test
     */
    public function Comment_コメントを追加できるか()
    {
        factory(Product::class)->create();
        $product = Product::first();

        $text = 'Sample';

        $response = $this->actingAs($this->user)->POST('comments.store',
        compact('text'));

        $comments = $product->comments()->get();

        $response->assertStatus(201)
            ->assertJsonFragment([
                "author" => [
                    "name" => $this->user->name,
                ],
                "text" => $text,
            ]);

            // DBにコメントが１件登録されているか
            $this->assertEquals(1, $comments->count());
            // 内容がAPIでリクエストしたものと一致するか
            $this->assertEquals($text, $comments[0]->text);

    }
}
