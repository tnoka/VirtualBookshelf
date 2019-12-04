<?php

namespace Tests\Feature;

use App\Product;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductListApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function ProductList_正しい構造のJSONを返却する()
    {
        // 5つのデータを生成
        factory(Product::class, 5)->create();

        $response = $this->json('GET', route('product.index'));

        // データ作成日の降順で取得
        $products = Product::with(['owner'])->orderBy('created_at', 'desc')->get();

        // d

    }
}
