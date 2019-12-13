<?php

namespace App\Http\Controllers;

use App\Product;
use App\Comment;
use App\Follow;
use App\Http\Requests\StoreProduct;
use App\Http\Requests\StoreComment;
use illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $products = Product::with(['owner', 'favorite'])->orderBy(Product::CREATED_AT, 'desc')->paginate();

        return $products;
    }

    // タイムライン
    public function productTimeLine(Product $product, Follow $follow)
    {
        $user = auth()->user();
        // ログインしているユーザーがフォローしているユーザーのIDを取得
        $follow_ids = $follow->followIds($user->id);
        
        $timelines = $product->getTimeLine($user->id, $follow_ids);

        return view('product.timeline', [
            'user' => $user,
            'timelines' => $timelines
        ]);
    }

    // 本の詳細
    public function show(string $id)
    {
        $product = Product::where('id', $id)->with(['owner', 'comments.author', 'favorite'])->first();

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

    // コメント投稿
    public function addComment(Product $product, StoreComment $request)
    {
        $comment = new Comment();
        $comment->text = $request->get('text');
        $comment->user_id = Auth::user()->id;
        $product->comments()->save($comment);

        $new_comment = Comment::where('id', $comment->id)->with('author')->first();

        return response($new_comment, 201);
    }

    // いいね（読みたい本）
    public function favorite(string $id)
    {
        $product = Product::where('id', $id)->with('favorite')->first();

        if(! $product) {
            abort(404);
        }

        $product->favorite()->detach(Auth::user()->id);
        $product->favorite()->attach(Auth::user()->id);

        return["product_id" => $id];
    }

    // いいね解除
    public function unFavorite(string $id)
    {
        $product = Product::where('id', $id)->with('favorite')->first();

        if(! $product) {
            abort(404);
        }

        $product->favorite()->detach(Auth::user()->id);

        return ["product_id" => $id];
    }

}