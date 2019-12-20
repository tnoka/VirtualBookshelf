<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favorite;
use App\Follow;
use App\Product;
use App\User;

class FavoritesController extends Controller
{
    public function index(Favorite $favorite, User $user, Product $product, Follow $follow, $id)
    {
        $login_user  = auth()->user();
        $user = $user->getUser($id);
        $favorites = $favorite->getFavorite($id);
        $favorite_count = $favorite->getFavoritesCount($id);
        $is_following = $login_user->isFollowing($id);
        $is_followed = $login_user->isFollowed($id);
        $product_count = $product->getProductCount($id);
        $follow_count = $follow->getFollowerCount($id);
        $follower_count = $follow->getFollowerCount($id);
        return view('favorites.index',
        [
            'user' => $user,
            'favorites' => $favorites,
            'favorite_count' => $favorite_count,
            'is_following' => $is_following,
            'is_followed' => $is_followed,
            'product_count' => $product_count,
            'follow_count' => $follow_count,
            'follower_count' => $follower_count,
        ]);

    }

    public function store(Request $request, Favorite $favorite)
    {
        $user = auth()->user();
        $product_id = $request->product_id;
        $check_favorite = $favorite->checkFavorite($user->id, $product_id);

        if(!$check_favorite)
        {
            $favorite->storeFavorite($user->id, $product_id);
            return back();
        }

        return back();
    }

    public function destroy(Favorite $favorite)
    {
        $user_id = $favorite->user_id;
        $product_id = $favorite->product_id;
        $favorite_id = $favorite->id;
        $check_favorite = $favorite->checkFavorite($user_id, $product_id);

        if($check_favorite)
        {
            $favorite->destroyFavorite($favorite_id);
            return back();
        }

        return back();
    }
}
