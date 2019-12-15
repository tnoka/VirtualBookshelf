<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favorite;

class FavoritesController extends Controller
{
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
