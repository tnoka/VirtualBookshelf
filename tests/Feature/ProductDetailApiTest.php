<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Product;


class ProductDetailApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function ProductDetail_正しい構造のJSONを返却()
    {
        factory(Product::class)->create();
        $product = Product::first();

        $response = $this->json('GET', route('product.show', [
            'id' => $product->id,                   
        ]));

        $response->assertStatus(200)
                ->assertJsonFragment([ //レスポンスJsonの項目が期待値と一致しているか
                    'id' => $product->id,
                    'url' => $product->url,
                    'owner' => [
                        'name' => $product->owner->name,
                    ],
                ]);
    }
}
