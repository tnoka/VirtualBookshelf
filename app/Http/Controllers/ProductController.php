<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProduct;
use App\Product;
use illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        // 認証
        $this->middleware('auth')->except(['index', 'show']);
    }

    // 本の一覧
    public function index()
    {
        $products = Product::with(['owner'])->orderBy(Product::CREATED_AT, 'desc')->paginate();

        return $products;
    }

    // 本の詳細
    public function show(string $id)
    {
        $product = Product::where('id', $id)->with(['owner'])->first();

        return $product ?? abort(404);
    }

    // 本の投稿
    public function store(StoreProduct $request, product $product)
    {
        $user = auth()->user();
        $extension = $request->product_image->extension();
        $product = new Product();
        $product->product_image = $product->id . '.' . $extension;
        Storage::cloud()->putFileAs('', $request->product_image, $product->product_image, 'public');
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['product_image'] = $product->product_image;
            $product->productStore($user->id, $data);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            // DBとの不整合を避けるためアップロードしたファイルを削除
            Storage::cloud()->delete($product->product_image);
            throw $exception;
        }


        return response($product, 201);

    }



    public function create(StoreProduct $request)
    {
        // 拡張子を取得
        $extension = $request->product->extension();

        $product = new Product();

        $product->filename = $product->id . '.' . $extension;

        // S3にファイルを保存
        Storage::cloud()->putFileAs('', $request->product, $product->filename, 'public');

        // エラー時にファイルを削除を行うため
        DB::beginTransaction();

        try {
            Auth::user()->product()->save($product);
            DB::commit();
        } catch(\Exception $extension) {
            DB::rollBack();
            // DBとの不整合を避けるためアップロードしたファイルを削除
            Storage::cloud()->delete($product->filename);
            throw $extension;
        }
        return response($product, 201);
    }

}