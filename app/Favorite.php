<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    public $timestamps = false;

    // いいねの判定
    public function checkFavorite(Int $user_id, $product_id)
    {
        return (boolean) $this->where('user_id', $user_id)->where('product_id', $product_id)->first();
    }

    // いいねをつける
    public function storeFavorite(Int $user_id, $product_id)
    {
        $this->user_id = $user_id;
        $this->product_id = $product_id;
        $this->save();

        return;
    }

    // いいねを解除
    public function destroyFavorite(Int $favorite_id)
    {
        return $this->where('id', $favorite_id)->delete();
    }
}
